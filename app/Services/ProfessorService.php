<?php

namespace Seracademico\Services;

use Seracademico\Repositories\ProfessorRepository;
use Seracademico\Entities\Professor;
use Seracademico\Repositories\EnderecoRepository;
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
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @param ProfessorRepository $repository
     * @param EnderecoRepository $enderecoRepository
     */
    public function __construct(ProfessorRepository $repository, EnderecoRepository $enderecoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $professor = $this->repository->with('endereco.bairro.cidade.estado')->find($id);
        //dd($professor->endereco->cep);
        #Verificando se o registro foi encontrado
        if(!$professor) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $professor;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Professor
    {
        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['path_image'] = $fileName;

            #destruindo o img do array
            unset($data['img']);
        }

        #Criando no banco de dados
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #setando o endereco
        $data['endereco_id'] = $endereco->id;

        #Salvando o registro pincipal
        $professor =  $this->repository->create($this->tratamentoDatas($data));

        #Verificando se foi criado no banco de dados
        if(!$professor) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Professor
    {
        #Atualizando no banco de dados
        $professor = $this->repository->update($this->tratamentoDatas($data), $id);
        $endereco  = $this->enderecoRepository->update($data['endereco'], $professor->endereco->id);

        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();


            #removendo a imagem antiga
            if ($professor->path_image != null) {
                unlink(__DIR__ . "/../../public/" . $this->destinationPath . $professor->path_image);
            }

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $professor->path_image = $fileName;
            $professor->save();

            #destruindo o img do array
            unset($data['img']);
        }


        #Verificando se foi atualizado no banco de dados
        if(!$professor || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::lists('nome', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array $data) : array
    {
        #tratando as datas
        $data['data_admissao']   = Carbon::createFromFormat("d/m/Y", $data['data_admissao']);
        $data['data_nascimento'] = Carbon::createFromFormat("d/m/Y", $data['data_nascimento']);
        $data['data_expedicao']  = Carbon::createFromFormat("d/m/Y", $data['data_expedicao']);

        #retorno
        return $data;
    }
}