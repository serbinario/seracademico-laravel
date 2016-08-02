<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\TaxaRepository;
use Seracademico\Entities\Financeiro\Taxa;
//use Carbon\Carbon;

class TaxaService
{
    /**
     * @var TaxaRepository
     */
    private $repository;

    /**
     * @param TaxaRepository $repository
     */
    public function __construct(TaxaRepository $repository)
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
        $taxa = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$taxa) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $taxa;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Taxa
    {   
        #Salvando o registro pincipal
        $taxa =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$taxa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $taxa;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Taxa
     * @throws \Exception
     */
    public function update(array $data, int $id) : Taxa
    {
        #Atualizando no banco de dados
        $taxa = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$taxa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $taxa;
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

    /**
     * @param array $dados
     * @return mixed
     * @throws \Exception
     */
    public function getTaxas(array $dados)
    {
        # Verificando a array de entrada
        if(!isset($dados['idTipoTaxa']) && !is_numeric($dados['idTipoTaxa'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando a taxa
        $taxas = $this->repository->findWhere(['tipo_taxa_id' => $dados['idTipoTaxa']]);
        
        # Verificando a existência das taxas
        if(count($taxas) == 0) {
            throw new \Exception('Nenhuma taxa foi encontrada');
        }

        # retorno
        return $taxas;
    }
}