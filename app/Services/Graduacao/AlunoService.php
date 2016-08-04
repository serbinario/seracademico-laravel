<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Repositories\SituacaoAlunoRepositoryEloquent;
use Seracademico\Validators\Graduacao\AlunoValidator;
use Seracademico\Facades\ParametroMatriculaFacade;

class AlunoService
{
    /**
     * @var AlunoRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var SituacaoAlunoRepositoryEloquent
     */
    private $situacaoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * AlunoService constructor.
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     * @param SituacaoAlunoRepositoryEloquent $situacaoRepository
     */
    public function __construct(
        AlunoRepository $repository,
        EnderecoRepository $enderecoRepository,
        PessoaRepository $pessoaRepository,
        SituacaoAlunoRepositoryEloquent $situacaoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
        $this->situacaoRepository = $situacaoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados

        $relacionamentos = [
            'pessoa.endereco.bairro.cidade.estado',
            'pessoa.estadoCivil',
            'pessoa.sexo',
            'pessoa.turno',
            'pessoa.grauInstrucao',
            'pessoa.profissao',
            'pessoa.corRaca',
            'pessoa.ufNascimento',
        ];

        $aluno = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado!');
        }

        #retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @return Aluno
     * @throws \Exception
     */
    public function store(array $data) : Aluno
    {
        #regras de negócios
        $this->tratamentoImagem($data);
        $this->tratamentoMatricula($data);
        $this->tratamentoCurso($data);

        # Recuperando os semestres de configurção de matrícula
        $semestres = [
            ParametroMatriculaFacade::getSemestreVigente(),
            ParametroMatriculaFacade::getSemestreSelMatricula()
        ];

        # Recuperando a pessoa pelo cpf
        $objPessoa = $this->pessoaRepository->with('endereco.bairro.cidade.estado')->findWhere(['cpf' => $data['pessoa']['cpf']]);
        $endereco  = null;

        # Verificando se a pesso já existe
        if(count($objPessoa) > 0) {
            #aAlterando a pessoa e o endereço
            $pessoa   = $this->pessoaRepository->update($data['pessoa'], $objPessoa[0]->id);
            $endereco =$this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);
        } else {
            #Criando o endereco e pessoa
            $endereco = $this->enderecoRepository->create($data['pessoa']['endereco']);

            # setando a chave estrangeira e criando a pessoa
            $data['pessoa']['enderecos_id'] = $endereco->id;
            $pessoa   = $this->pessoaRepository->create($data['pessoa']);
        }

        #setando as chaves estrageiras
        $data['pessoa_id'] = $pessoa->id;

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Regra de negócio para cadastro do semestre
        #Vinculando o aluno ao semestre vigente
        $aluno->semestres()->attach($semestres[0]->id);
        $aluno->semestres()->get()->last()->pivot->situacoes()->attach(1, ['data'=> new \DateTime('now')]);

        #Vinculando o currículo ao aluno
        $aluno->curriculos()->attach($data['curriculo_id']);

        #Retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Aluno
     * @throws \Exception
     */
    public function update(array $data, int $id) : Aluno
    {
        # Regras de negócio
        $this->tratamentoMatricula($data);

        # Recuperando o vestibulando
        $aluno = $this->repository->find($id);

        #Regras de negócios
        $this->tratamentoImagem($data, $aluno);

        #Atualizando no banco de dados
        $aluno    = $this->repository->update($data, $id);
        $pessoa   = $this->pessoaRepository->update($data['pessoa'], $aluno->pessoa->id);
        $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$aluno || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function tratamentoCurso(array &$data)
    {
        # Verificando se o curso foi informado
        if(!isset($data['curso_id'])) {
            throw new \Exception('Curso não informado');
        }

        # recuperando o currículo
        $curriculo = Curriculo::byCurso($data['curso_id']);

        # Verificando se o currículo foi encontrado
        if(!$curriculo && !count($curriculo) == 1) {
            throw new \Exception('Currículo não encontrado');
        }

        # tratando o array
        unset($data['curso_id']);
        $data['curriculo_id'] = $curriculo[0]->id;

        # retorno
        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoImagem(array &$data, $aluno = "")
    {
        #tratando a imagem
        foreach ($data as $key => $value) {
            $explode = explode("_", $key);

            if (count($explode) > 0 && $explode[0] == "path") {
                $file = $data[$key];
                $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

                # Validando a atualização
                if (!empty($aluno) && $aluno->{$key} != null) {
                    unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $aluno->{$key});
                }

                #Movendo a imagem
                $file->move($this->destinationPath, $fileName);

                #renomeando
                $data[$key] = $fileName;
            }
        }

        # retorno
        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoMatricula(array &$data) : array
    {
        # Validando o parâmetro
        if(isset($data['gerar_matricula']) && $data['gerar_matricula'] == 1) {
            # Gerando a matrícula
            $data['matricula'] = $this->gerarMatricula();
        }

        # retorno
        return $data;
    }

    /**
     * @return string
     */
    public function gerarMatricula()
    {
        # recuperando a data atual
        $now = new \DateTime('now');

        #retorno
        return $now->format('YmdHis');
    }

    /**
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }
    
    /**
     * @param array $dados
     * @param $idAluno
     * @return bool
     * @throws \Exception
     */
    public function saveHistorico(array $dados, $idAluno)
    {
        # Recuperando o aluno
        $aluno    = $this->repository->find($idAluno);
        $semestre = $aluno->semestres()->find($dados['semestre_id']);

        # Verificando o aluno foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado.');
        }

        # Verificando se o aluno já está inscrito nesse semestre
        if($semestre) {
            throw new \Exception('O Aluno já está inscrito no semestre informado.');
        }

        # Verificando se curso foi passado
        if(!isset($dados['curso_id'])) {
            throw new \Exception('Curso não informado.');
        }

        # recuperando o currúculo
        $curriculo = Curriculo::byCurso($dados['curso_id']);

        # Verificando se o currículo existe
        if(count($curriculo) == 0) {
            throw new \Exception('Currículo não encontrado.');
        }

        # Recuperando a data atual
        $now = new \DateTime('now');

        # Geração da matrícula
        $dados['matricula'] = $now->format('YmdHis');

        # matriculando o aluno
        # Regra de negócio para o semestre
        $aluno->semestres()->attach($dados['semestre_id']);

        #Adicionando o currículo ao aluno
        $aluno->curriculos()->attach($curriculo[0]->id);

        # cadastrando a situação
        $aluno->semestres()->get()->last()->pivot->situacoes()
            ->attach(1, ['data' => $now->format('YmdHis'), 'curriculo_destino_id' => $curriculo[0]->id]);

        #retorno
        return true;
    }

    /**
     * @param $idAlunoSemestre
     * @return bool
     */
    public function deleteHistorico($idAlunoSemestre)
    {
        \DB::table('fac_alunos_semestres')->where('id', $idAlunoSemestre)->delete();

        return true;
    }

    /**
     * @param array $dados
     * @param $idSemestre
     * @return bool
     * @throws \Exception
     */
    public function saveSituacao(array $dados, $idSemestre)
    {
        # Recuperando a data atual
        $now = new \DateTime('now');

        # Recuperando a situacao e o aluno
        $aluno    = $this->repository->find($dados['aluno_id']);
        $situacao = $this->situacaoRepository->find($dados['situacao_id']);

        # Validando os objetos
        if(!$aluno || !$situacao) {
            throw new \Exception('Dados inválidos.');
        }

        # Curriculo origem e destino
        $curriculoOrigem  = $aluno->curriculos()->get()->last()->id;
        $curriculoDestino = null;

        # Verificando se o curso destino foi informado
        if(isset($dados['curso_destino_id'])) {
            # Recuperando o currículo
            $curriculo = Curriculo::byCurso($dados['curso_destino_id']);
           
            # Vendo se o curriculo foi encontrado
            $curriculoDestino = count($curriculo) == 1 ? $curriculo[0]->id : null;
        }

        # Verificando se o currículo destino foi passado
        if($curriculoDestino) {
            # Cadastrado o novo curso
            $aluno->curriculos()->attach($curriculoDestino);
        }

        #salvando a situacão
        $aluno->semestres()->find($idSemestre)->pivot->situacoes()
            ->attach($situacao->id, [
                'observacao' => $dados['observacao'],
                'data' => $now->format('Y-m-d'),
                'curriculo_origem_id' => $curriculoOrigem,
                'curriculo_destino_id' => $curriculoDestino
            ]);

        # retorno
        return true;
    }

    /**
     * @param $idAlunoSituacao
     * @return bool
     */
    public function deleteSituacao($idAlunoSituacao)
    {
        \DB::table('fac_alunos_situacoes')->where('id', $idAlunoSituacao)->delete();

        return true;
    }    

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function search($key, $value)
    {
        # Joins
        $relacionamentos = [
            'instituicaoEscolar',
            'endereco.bairro.cidade.estado',
        ];

        # Fazendo a consulta
        $aluno = $this->pessoaRepository->with($relacionamentos)->findWhere([ $key =>$value ]);

        # Verificando o se o vestibulando foi recuperado
        if(count($aluno) == 0) {
            throw new \Exception("Dados não encontrados");
        }

        # Retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function updatePeriodo(array $data)
    {
        # Verificando os dados do parâmetro
        if (!isset($data['idAluno']) && !isset($data['idSemestre']) && !isset($data['periodo'])) {
            throw new \Exception('Dados Inválidos!');
        }

        # Recuperando o aluno, semestre e pivot
        $aluno    = $this->repository->find($data['idAluno']);
        $semestre = $aluno->semestres()->find($data['idSemestre']);
        $pivot    = $semestre->pivot;

        # Alterando o período
        $pivot->periodo = $data['periodo'];
        $pivot->save();

        # retorno
        return true;
    }
}