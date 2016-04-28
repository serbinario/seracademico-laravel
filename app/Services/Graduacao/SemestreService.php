<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\SemestreRepository;
use Seracademico\Entities\Graduacao\Semestre;

class SemestreService
{
    /**
     * @var SemestreRepository
     */
    private $repository;

    /**
     * @param SemestreRepository $repository
     */
    public function __construct(SemestreRepository $repository)
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
        $semestre = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$semestre) {
            throw new \Exception('Semestre não encontrada!');
        }

        #retorno
        return $semestre;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Semestre
    {
        #Salvando o registro pincipal
        $semestre =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$semestre) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $semestre;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Semestre
    {
        #Atualizando no banco de dados
        $semestre = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$semestre) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $semestre;
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
            throw new \Exception('Ocorreu um erro ao tentar remover o período!');
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
}