<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Entities\Graduacao\VestibulandoNotaVestibular;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\Graduacao\VestibulandoNotaVestibularRepository;
use Seracademico\Repositories\Graduacao\VestibulandoRepository;
use Seracademico\Repositories\Graduacao\VestibularRepository;
use Seracademico\Repositories\PessoaRepository;

class VestibulandoService
{
    /**
     * @var VestibulandoRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @var VestibularRepository
     */
    private $vestibularRepository;

    /**
     * @var VestibulandoNotaVestibularRepository
     */
    private $notaRepository;

    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @param PessoaRepository $pessoaRepository
     * @param VestibulandoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param VestibularRepository $vestibularRepository
     * @param VestibulandoNotaVestibularRepository $notaRepository
     */
    public function __construct(
        PessoaRepository $pessoaRepository,
        VestibulandoRepository $repository,
        EnderecoRepository $enderecoRepository,
        VestibularRepository $vestibularRepository,
        VestibulandoNotaVestibularRepository $notaRepository)
    {
        $this->repository           = $repository;
        $this->pessoaRepository     = $pessoaRepository;
        $this->enderecoRepository   = $enderecoRepository;
        $this->vestibularRepository = $vestibularRepository;
        $this->notaRepository       = $notaRepository;
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
            'pessoa.instituicaoEscolar',
            'pessoa.endereco.bairro.cidade.estado',
            'pessoa.estadoCivil',
            'pessoa.sexo',
            'pessoa.turno',
            'pessoa.grauInstrucao',
            'pessoa.profissao',
            'pessoa.corRaca',
            'pessoa.ufNascimento',
        ];

        $vestibulando = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$vestibulando) {
            throw new \Exception('Vestibulando não encontrado!');
        }

        #retorno
        return $vestibulando;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Vestibulando
    {
        #tratamento de dados do aluno
        $this->tratamentoCampos($data);
        $this->tratamentoInscricao($data);
        $this->tratamentoImagem($data);

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
        $vestibulando =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$vestibulando) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #tratamento vestibular
        $this->tratamentoVestibular($vestibulando);

        #Retorno
        return $vestibulando;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Vestibulando
    {
        # Recuperando o vestibulando
        $vestibulando = $this->repository->find($id);

        #tratamento de dados do aluno
        $this->tratamentoCampos($data);
        $this->tratamentoInscricao($data, $id);
        $this->tratamentoImagem($data, $vestibulando);

        #Atualizando no banco de dados
        $vestibulando = $this->repository->update($data, $id);
        $pessoa       = $this->pessoaRepository->update($data['pessoa'], $vestibulando->pessoa->id);
        $endereco     = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$vestibulando || !$endereco || !$pessoa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $vestibulando;
    }

    /**
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
                if(count($expressao) > 1) {
                    switch (count($expressao)) {
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
    public function tratamentoImagem(array &$data, $vestibulando = "")
    {
        #tratando a imagem
        if(isset($data['pessoa']['img'])) {
            $file     = $data['pessoa']['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            # Validando a atualização
            if(!empty($vestibulando) && $vestibulando->pessoa->path_image != null) {
                unlink(__DIR__ . "/../../public/" . $this->destinationPath . $vestibulando->pessoa->path_image);
            }

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['pessoa']['path_image'] = $fileName;

            #destruindo o img do array
            unset($data['pessoa']['img']);
        }

        # retorno
        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoInscricao(array &$data, $id = "") : array
    {
        # Variáveis
        $idVestibular = 0;

        # Validando o parâmetro
        if(isset($data['gerar_inscricao']) && $data['gerar_inscricao'] == 1) {
            if($id) {
                $vestibulando = $this->repository->find($id);
                $idVestibular = $vestibulando->vestibular->id;

                if($vestibulando->gerar_inscricao == 1) {
                    unset($data['gerar_inscricao']);
                    return $data;
                }
            } else {
                $idVestibular = $data['vestibular_id'];
            }

            # Gerando a inscrição
            $data['inscricao'] = $this->gerarInscricao($idVestibular);
        }

        # retorno
        return $data;
    }

    /**
     * @return string
     */
    public function gerarInscricao($idVestibular)
    {
        # Recuperando o vestibular
        $objVestibular = $this->vestibularRepository->find($idVestibular);
        $lastIncricao  = $objVestibular->vestibulandos->max('inscricao');

        # Verificando se o vestibular possui vestibulando
        if(!$lastIncricao) {
            return '0001';
        }

        # Recuperando a ultima inscrição do vestibular, algoritmo de incremento
        # para nova inscrição
        $lastIncricao = (int) $lastIncricao;
        $newInscricao = str_pad(($lastIncricao + 1), 4, "0", STR_PAD_LEFT) ;

        # retorno
        return $newInscricao;
    }

    /**
     * @param Aluno $aluno
     * @throws \Exception
     */
    public function tratamentoVestibular(Vestibulando $vestibulando)
    {
        # Verificando o vestibular
        if(!$vestibulando->vestibular) {
            throw new \Exception('Vestibular não existe');
        }

        # Verificando se o vestibulando já possui notas
        if(count($vestibulando->notasVestibular) > 0) {
            return false;
        }

        # Recuperando as matérias
        $idVestibular = $vestibulando->vestibular->id;
        $materias     = \DB::table('fac_materias')
                        ->select('id')
                        ->whereIn('id', function ($query) use ($idVestibular) {
                            $query->from('fac_vestibular_curso_materia')
                                ->distinct()
                                ->select('fac_vestibular_curso_materia.materia_id')
                                ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_materia.vestibular_curso_id')
                                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_vestibulares_cursos.curso_id')
                                ->join('fac_vestibulares', 'fac_vestibulares.id', '=', 'fac_vestibulares_cursos.vestibular_id')
                                ->where('fac_vestibulares.id', $idVestibular)
                                ->get();
                        })->get();

        # Criando as notas dos alunos
        foreach ($materias as $materia) {
            $vestibulando->notasVestibular()->create(['materia_id' => $materia->id]);
        }

        # Retorno
        return true;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function findNota(array $data)
    {
        # Validando os dados da requisição
        if(!isset($data['idNota']) && !is_numeric($data['idNota']) &&
            !isset($data['idVestibulando']) && !is_numeric($data['idVestibulando'])) {
            throw new \Exception('Dados inválidos');
        }

        # Recuperando a nota
        $nota = $this->notaRepository->find($data['idNota']);

        # Verificando se a nota existe
        if(!$nota) {
            throw new \Exception('Nota não existe');
        }

        # Retorno
        return $nota;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateNota(array $data, int $id) : VestibulandoNotaVestibular
    {
        #Atualizando no banco de dados
        $nota = $this->notaRepository->update($data, $id);


        #$nota se foi atualizado no banco de dados
        if(!$nota) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $nota;
    }

    /**
     * @param $dados
     * @param $idVestibulando
     * @return bool
     * @throws \Exception
     */
    public function updateInclusao($dados, $idVestibulando)
    {
        # Recuperando o vestibulando e o currículo
        $vestibulando = $this->repository->find($idVestibulando);
        $curriculo    = Entities\Graduacao\Curriculo::byCurso($dados['curso_id']);

        # Verificando se o vestibulando existe
        if(!$vestibulando && !$curriculo) {
            throw new \Exception('Vestibulando não existe');
        }

        # Regra de negócio do currículo
        unset($dados['curso_id']);
        $dados['curriculo_id'] = $curriculo[0]->id;
        $dados['situacao_id']  = 3;
        $dados['periodo']      = 1;

        #Regrade negócio matrícula
        $dataNow = new \DateTime('now');
        $dados['matricula']    = $dataNow->format('YmdHis');

        #atualizando o matriculando
        $vestibulando->situacao_id = $dados['situacao_id'];
        $vestibulando->periodo     = $dados['periodo'];
        $vestibulando->matricula   = $dados['matricula'];
        $vestibulando->save();


        # Atualizando a inclusão
        $inclusao = $vestibulando->inclusao;
        $inclusao->curriculo_id = $dados['curriculo_id'];
        $inclusao->forma_admissao_id = $dados['forma_admissao_id'];
        $inclusao->data_inclusao = $dados['data_inclusao'];
        $inclusao->turno_id = $dados['turno_id'];
        $inclusao->save();

        #retorno
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
        $vestibulando = $this->pessoaRepository->with($relacionamentos)->findWhere([ $key =>$value ]);

        # Verificando o se o vestibulando foi recuperado
        if(count($vestibulando) == 0) {
            throw new \Exception("Dados não encontrados");
        }

        # Retorno
        return $vestibulando;
    }
}