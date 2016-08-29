<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\PlanoEnsinoRepository;
use Seracademico\Entities\Graduacao\PlanoEnsino;
//use Carbon\Carbon;

class PlanoEnsinoService
{
    /**
     * @var PlanoEnsinoRepository
     */
    private $repository;

    /**
     * @param PlanoEnsinoRepository $repository
     */
    public function __construct(PlanoEnsinoRepository $repository)
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
        $planoEnsino = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$planoEnsino) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : PlanoEnsino
    {
        #Salvando o registro pincipal
        $planoEnsino =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : PlanoEnsino
    {
        #Atualizando no banco de dados
        $planoEnsino = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
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

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

}