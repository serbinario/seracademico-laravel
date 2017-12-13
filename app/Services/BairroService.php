<?php

namespace Seracademico\Services;

use Seracademico\Repositories\BairroRepository;
use Seracademico\Entities\Bairro;

class BairroService
{
    /**
     * @var BairroRepository
     */
    private $repository;

    /**
     * @param BairroRepository $repository
     */
    public function __construct(BairroRepository $repository)
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
        $departamento = $this->repository->with(['cidade.estado'])->find($id);

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
    public function store(array $data) : Bairro
    {
        #Salvando o registro pincipal
        $bairro =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$bairro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $bairro;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Bairro
    {
        #Atualizando no banco de dados
        $bairro = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$bairro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $bairro;
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