<?php

namespace Seracademico\Services;

use Seracademico\Entities\Sala;
use Seracademico\Repositories\SalaRepository;

class SalaService
{
    /**
     * @var SalaRepository
     */
    private $repository;

    /**
     * @param SalaRepository $repository
     */
    public function __construct(SalaRepository $repository)
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
        $sala = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$sala) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $sala;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Sala
    {
        #Salvando o registro pincipal
        $sala =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$sala) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $sala;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Sala
    {
        #Atualizando no banco de dados
        $sala = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$sala) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $sala;
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