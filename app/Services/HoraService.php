<?php

namespace Seracademico\Services;

use Seracademico\Repositories\HoraRepository;
use Seracademico\Entities\Hora;

class HoraService
{
    /**
     * @var HoraRepository
     */
    private $repository;

    /**
     * @param HoraRepository $repository
     */
    public function __construct(HoraRepository $repository)
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
        $hora = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$hora) {
            throw new \Exception('Hora não encontrada!');
        }

        #retorno
        return $hora;
    }

    /**
     * @param array $data
     * @return Hora
     * @throws \Exception
     */
    public function store(array $data) : Hora
    {
        #Salvando o registro pincipal
        $hora =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$hora) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $hora;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Hora
     * @throws \Exception
     */
    public function update(array $data, int $id) : Hora
    {
        #Atualizando no banco de dados
        $hora = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$hora) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $hora;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $hora = $this->repository->find($id);


        # Verifiando se a Hora foi recuperada
        if(!$hora) {
            throw new \Exception('Hora não encontrada!');
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