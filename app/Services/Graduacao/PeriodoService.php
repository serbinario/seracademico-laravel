<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\PeriodoRepository;
use Seracademico\Entities\Graduacao\Periodo;

class PeriodoService
{
    /**
     * @var PeriodoRepository
     */
    private $repository;

    /**
     * @param PeriodoRepository $repository
     */
    public function __construct(PeriodoRepository $repository)
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
        $disciplina = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$disciplina) {
            throw new \Exception('Período não encontrada!');
        }

        #retorno
        return $disciplina;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Periodo
    {
        #Salvando o registro pincipal
        $periodo =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$periodo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $periodo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Periodo
    {
        #Atualizando no banco de dados
        $periodo = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$periodo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $periodo;
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