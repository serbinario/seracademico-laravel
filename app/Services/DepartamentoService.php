<?php

namespace Seracademico\Services;

use Seracademico\Repositories\DepartamentoRepository;
use Seracademico\Entities\Departamento;

class DepartamentoService
{
    /**
     * @var DepartamentoRepository
     */
    private $repository;

    /**
     * @param DepartamentoRepository $repository
     */
    public function __construct(DepartamentoRepository $repository)
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
        $departamento = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$departamento) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $departamento;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Departamento
    {
        #Salvando o registro pincipal
        $departamento =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$departamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $departamento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Departamento
    {
        #Atualizando no banco de dados
        $departamento = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$departamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $departamento;
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
}