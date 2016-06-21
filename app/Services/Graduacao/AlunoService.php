<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Validators\Graduacao\AlunoValidator;

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
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * AlunoService constructor.
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     */
    public function __construct(
        AlunoRepository $repository,
        EnderecoRepository $enderecoRepository,
        PessoaRepository $pessoaRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
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
     * @return array
     */
    public function store(array $data) : Aluno
    {
        #regras de negócios
        $this->tratamentoSemestre($data);
        $this->tratamentoImagem($data);
        $this->tratamentoMatricula($data);
        $this->tratamentoCurso($data);

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
        #Recuperando os semestres de configuração
        $semestres = $this->getParametrosMatricula();

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
     * @return mixed
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
     */
    public function tratamentoSemestre(array &$data)
    {
        # Recuperando os semestres
        $semestres = $this->getParametrosMatricula();

        # Verificando se os semestres de configuração estão válidos
        if(count($semestres) == 2) {
            new \Exception('Semestres não encontrados, por favor verifique na em "Configurações > Matrícula"');
        }

        #retorno
        return true;
    }

    /**
     * @param array $data
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
     * @param array $models
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
            $model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id']);
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
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
     * @throws \Exception
     */
    public function saveHistorico(array $dados, $idAluno)
    {
        # Recuperando o aluno
        $aluno = $this->repository->find($idAluno);

        # Verificando o aluno foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado.');
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
        $aluno->semestres()->get()->last()->pivot->situacoes()->attach(1, ['data' => $now->format('YmdHis')]);

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
     * @param $idAlunoSemestre
     * @return bool
     */
    public function deleteSituacao($idAlunoSituacao)
    {
        \DB::table('fac_alunos_situacoes')->where('id', $idAlunoSituacao)->delete();

        return true;
    }

    /**
     * @return mixed
     */
    public function getParametrosMatricula()
    {
        try {
            # Recuperando o item de parâmetro do semestre vigente
            $queryParameter = \DB::table('fac_parametros')
                ->join('fac_parametros_itens', 'fac_parametros_itens.parametro_id', '=', 'fac_parametros.id')
                ->select(['fac_parametros_itens.valor', 'fac_parametros_itens.nome'])
                ->where('fac_parametros_itens.id', 2)
                ->orWhere('fac_parametros_itens.id', 3)
                ->get();

            # Validando o parametro
            if(count($queryParameter) !== 2) {
                throw new \Exception('Parâmetro do semestre vigente não configurado');
            }

            # Recuperando o semestre
            $querySemestre = \DB::table('fac_semestres')
                ->select(['fac_semestres.id', 'fac_semestres.nome'])
                ->where('fac_semestres.nome', $queryParameter[0]->valor)
                ->orWhere('fac_semestres.nome', $queryParameter[1]->valor)
                ->where('fac_semestres.ativo', 1)
                ->get();

            # Validando o parametro
            if(count($querySemestre) !== 2) {
                throw new \Exception('Semestre não encontrado, verifique o item "Semestre vigente" no parâmetro "Matrícula" em configurações.');
            }

            #Retorno
            return $querySemestre;
        } catch (\Throwable $e) {
            #Retorno
            return $e->getMessage();
        }
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
}