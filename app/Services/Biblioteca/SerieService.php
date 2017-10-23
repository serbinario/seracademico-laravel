<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Entities\Biblioteca\Serie;
use Seracademico\Repositories\Biblioteca\SerieRepository;

class SerieService
{
    /**
     * @var SerieRepository
     */
    private $repository;

    /**
     * @param SerieRepository $repository
     */
    public function __construct(SerieRepository $repository)
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
        $serie = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$serie) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $serie;
    }

    /**
     * @param array $data
     * @return Serie
     * @throws \Exception
     */
    public function store(array $data) : Serie
    {
        #Salvando o registro pincipal
        $serie =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$serie) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $serie;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Serie
     * @throws \Exception
     */
    public function update(array $data, int $id) : Serie
    {
        #Atualizando no banco de dados
        $serie = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$serie) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $serie;
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