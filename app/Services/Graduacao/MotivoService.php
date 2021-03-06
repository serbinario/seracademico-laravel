<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\MotivoRepository;
use Seracademico\Entities\Graduacao\Motivo;

class MotivoService
{
    /**
     * @var MotivoRepository
     */
    private $repository;

    /**
     * MotivoService constructor.
     * @param MotivoRepository $repository
     */
    public function __construct(MotivoRepository $repository)
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
        $motivo = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$motivo) {
            throw new \Exception('Motivo não encontrada!');
        }

        #retorno
        return $motivo;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Motivo
    {
        #Salvando o registro pincipal
        $motivo =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$motivo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $motivo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Motivo
    {
        #Atualizando no banco de dados
        $motivo = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$motivo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $motivo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $motivo = $this->repository->find($id);


        # Verifiando se a motivo foi recuperada
        if(!$motivo) {
            throw new \Exception('Motivo não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($id);

        #Retorno
        return true;
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