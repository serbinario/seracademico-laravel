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
        $this->tratamentoImagem($data);
//        #setando o nivel do sistema
//        $data['tipo_nivel_sistema_id'] = 2;


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
}