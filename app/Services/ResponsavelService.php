<?php

namespace Seracademico\Services;

use Seracademico\Repositories\ResponsavelRepository;
use Seracademico\Entities\Responsavel;
//use Carbon\Carbon;

class ResponsavelService
{
    /**
     * @var ResponsavelRepository
     */
    private $repository;

    /**
     * @param ResponsavelRepository $repository
     */
    public function __construct(ResponsavelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $responsavel = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$responsavel) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $responsavel;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Responsavel
    {
        #Salvando o registro pincipal
        $responsavel =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$responsavel) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $responsavel;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Responsavel
    {
        #Atualizando no banco de dados
        $responsavel = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$responsavel) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $responsavel;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return true;
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
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

}