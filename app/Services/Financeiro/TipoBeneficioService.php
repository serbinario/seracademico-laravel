<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\TipoBeneficioRepository;
use Seracademico\Entities\Financeiro\TipoBeneficio;
//use Carbon\Carbon;

class TipoBeneficioService
{
    /**
     * @var TipoBeneficioRepository
     */
    private $repository;

    /**
     * @param TipoBeneficioRepository $repository
     */
    public function __construct(TipoBeneficioRepository $repository)
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
        $tipoBeneficio = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$tipoBeneficio) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $tipoBeneficio;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : TipoBeneficio
    {
        #Salvando o registro pincipal
        $tipoBeneficio =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$tipoBeneficio) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoBeneficio;
    }

    /**
     * @param array $data
     * @param int $id
     * @return TipoBeneficio
     * @throws \Exception
     */
    public function update(array $data, int $id) : TipoBeneficio
    {
        #Atualizando no banco de dados
        $tipoBeneficio = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$tipoBeneficio) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoBeneficio;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Recuperando o registro no banco de dados
        $tipoBeneficio = $this->repository->find($id);

        #Verificando se foi recuperado no banco de dados
        if(!$tipoBeneficio) {
            throw new \Exception('Tipo de benefício não encontrado!');
        }

        # Removendo no banco de dados
        $this->repository->delete($tipoBeneficio->id);

        #Retorno
        return $tipoBeneficio;
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