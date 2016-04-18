<?php

namespace Seracademico\Services;

use Seracademico\Repositories\TipoCursoRepository;
use Seracademico\Entities\TipoCurso;

class TipoCursoService
{
    /**
     * @var TipoCursoRepository
     */
    private $repository;

    /**
     * @param TipoCursoRepository $repository
     */
    public function __construct(TipoCursoRepository $repository)
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
        $tipoCurso = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$tipoCurso) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $tipoCurso;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : TipoCurso
    {
        #Salvando o registro pincipal
        $tipoCurso =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$tipoCurso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoCurso;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : TipoCurso
    {
        #Atualizando no banco de dados
        $tipoCurso = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$tipoCurso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoCurso;
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