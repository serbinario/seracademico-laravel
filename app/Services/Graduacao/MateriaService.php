<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\MateriaRepository;
use Seracademico\Entities\Graduacao\Materia;

class MateriaService
{
    /**
     * @var MateriaRepository
     */
    private $repository;

    /**
     * @param MateriaRepository $repository
     */
    public function __construct(MateriaRepository $repository)
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
        $materia = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$materia) {
            throw new \Exception('Matéria não encontrada!');
        }

        #retorno
        return $materia;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Materia
    {
        #Salvando o registro pincipal
        $materia =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$materia) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $materia;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Materia
    {
        #Atualizando no banco de dados
        $materia = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$materia) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $materia;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
         #Declarando variáveis de uso
         $result    = [];
         $expressao = [];

         #Criando e executando as consultas
         foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            if(count($expressao) > 1) {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
            } else {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::lists('nome', 'id');
            }

            # Limpando a expressão
            $expressao = [];
         }

         #retorno
         return $result;
    }
}