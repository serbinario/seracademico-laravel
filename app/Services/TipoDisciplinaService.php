<?php

namespace Seracademico\Services;

use Seracademico\Repositories\TipoDisciplinaRepository;
use Seracademico\Entities\TipoDisciplina;

class TipoDisciplinaService
{
    /**
     * @var TipoDisciplinaRepository
     */
    private $repository;

    /**
     * @param TipoDisciplinaRepository $repository
     */
    public function __construct(TipoDisciplinaRepository $repository)
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
        $tipoDisciplina = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$tipoDisciplina) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $tipoDisciplina;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : TipoDisciplina
    {
        #Salvando o registro pincipal
        $tipoDisciplina =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$tipoDisciplina) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoDisciplina;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : TipoDisciplina
    {
        #Atualizando no banco de dados
        $tipoDisciplina = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$tipoDisciplina) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoDisciplina;
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