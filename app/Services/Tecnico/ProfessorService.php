<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Repositories\Tecnico\ProfessorRepository;
use Seracademico\Entities\Tecnico\Professor;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Carbon\Carbon;

class ProfessorService
{
    /**
     * @var ProfessorRepository
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
     * ProfessorService constructor.
     * @param ProfessorRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     */
    public function __construct(ProfessorRepository $repository,
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

        #Recuperando o registro no banco de dados
        $professor = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$professor) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $professor;
    }

    /**
     * @param array $data
     * @return Professor
     * @throws \Exception
     */
    public function store(array $data) : Professor
    {
        # Tratamento imagens de cam
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Regras de negócios
        $this->tratamentoImagem($data);

        #injetando senha de acesso ao portal do aluno no array principal
        $this->loginPortalProfessor($data, $data['pessoa']['cpf']);

        # Recuperando a pessoa pelo cpf
        if(!empty($data['pessoa']['cpf'])) {
            $objPessoa = $this->pessoaRepository->with('pessoa.endereco.bairro.cidade.estado')->findWhere(['cpf' => empty($data['pessoa']['cpf']) ?? 0]);
        } else {
            $objPessoa = $this->pessoaRepository->with('pessoa.endereco.bairro.cidade.estado')->findWhere(['cnpj' => empty($data['pessoa']['cnpj']) ?? 0]);
        }

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
        $data['tipo_nivel_sistema_id'] = 4;
        $data['primeiro_acesso'] = 0;

        #Salvando o registro pincipal
        $professor =  $this->repository->create($data);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$professor->id} ";

            $pdo->query($query);

        } else if ($img && !$imgCam) {

            $this->insertImg($professor->id, 1);

        } else if ($imgCam && $img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$professor->id} ";

            $pdo->query($query);

        }

        #Verificando se foi criado no banco de dados
        if(!$professor) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param $data
     */
    public function loginPortalProfessor(&$data, $cpf)
    {
        $cpf = str_replace(array('.', '-'), "", $cpf);

        #tratando a senha
        $data['password'] = \bcrypt($cpf);

        #setando número de matricula como login do portal do aluno
        $data['login'] = $cpf;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Professor
     * @throws \Exception
     */
    public function update(array $data, int $id) : Professor
    {
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Regras de negócios
        $this->tratamentoCampos($data);

        # Recuperando o vestibulando
        $professor = $this->repository->find($id);

        $this->loginPortalProfessor($data, $professor->pessoa->cpf);

        # Regras de negócios
        $this->tratamentoImagem($data, $professor);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            $pdo->query($query);

        } else if ($img && !$imgCam) {

            $this->insertImg($professor->id, 1);

        } else if ($imgCam && $img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            $pdo->query($query);

        }

        #Atualizando no banco de dados
        $professor = $this->repository->update($data, $id);
        $pessoa   = $this->pessoaRepository->update($data['pessoa'], $professor->pessoa->id);
        $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$professor || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param $id
     */
    public function insertImg($id, $tipo)
    {
        #tratando a imagem
        if(isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {

            $tmpName = $_FILES['img']['tmp_name'];

            $fp = fopen($tmpName, 'r');

            $add = fread($fp, filesize($tmpName));

            $add = addslashes($add);

            fclose($fp);

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$add}', tipo_img = {$tipo} where id =  $id ";

            $pdo->query($query);

        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoImagem(array &$data, $model = "")
    {
        #tratando a imagem
        foreach ($data as $key => $value) {
            $explode = explode("_", $key);

            if (count($explode) > 0 && $explode[0] == "path") {
                $file = $data[$key];
                $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

                # Validando a atualização
                if (!empty($model) && $model->{$key} != null) {
                    unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $model->{$key});
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
     * @param bool $ajax
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
     * @param $id
     * @return string
     */
    public function getPathArquivo($id, $tipo)
    {
        # Recuperando o contrato
        $professor = $this->repository->find($id);

        #Retornando o caminho completo do arquivo
        return $this->destinationPath . $professor->$tipo;
    }
}