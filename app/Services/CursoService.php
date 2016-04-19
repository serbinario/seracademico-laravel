<?php

namespace Seracademico\Services;

use Carbon\Carbon;
use Seracademico\Repositories\CursoRepository;
use Seracademico\Entities\Curso;

class CursoService
{
    /**
     * @var CursoRepository
     */
    private $repository;

    /**
     * @param CursoRepository $repository
     */
    public function __construct(CursoRepository $repository)
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
        $curso = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$curso) {
            throw new \Exception('Curso não encontrado!');
        }

        #retorno
        return $curso;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Curso
    {
        #Salvando o registro pincipal
        $curso =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$curso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curso;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Curso
    {
        #Atualizando no banco de dados
        $curso = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$curso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curso;
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
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
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