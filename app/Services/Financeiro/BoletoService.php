<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\BoletoRepository;
use Seracademico\Entities\Financeiro\Boleto;
//use Carbon\Carbon;

class BoletoService
{
    /**
     * @var BoletoRepository
     */
    private $repository;

    /**
     * @param BoletoRepository $repository
     */
    public function __construct(BoletoRepository $repository)
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
        $boleto = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$boleto) {
            throw new \Exception('Boleto não encontrada!');
        }

        #retorno
        return $boleto;
    }

    /**
     * @param array $data
     * @return Boleto
     * @throws \Exception
     */
    public function store(array $data) : Boleto
    {   
        #Salvando o registro pincipal
        $boleto =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$boleto) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $boleto;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Boleto
     * @throws \Exception
     */
    public function update(array $data, int $id) : Boleto
    {
        #Atualizando no banco de dados
        $boleto = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$boleto) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $boleto;
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