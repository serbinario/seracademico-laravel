<?php

namespace Seracademico\Services;

use Seracademico\Repositories\PrimeiraEntradaRepository;
use Seracademico\Entities\PrimeiraEntrada;
//use Carbon\Carbon;

class PrimeiraEntradaService
{
    /**
     * @var PrimeiraEntradaRepository
     */
    private $repository;

    /**
     * @param PrimeiraEntradaRepository $repository
     */
    public function __construct(PrimeiraEntradaRepository $repository)
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
        $primeiraEntrada = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$primeiraEntrada) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $primeiraEntrada;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : PrimeiraEntrada
    {
        #Salvando o registro pincipal
        $primeiraEntrada =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$primeiraEntrada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $primeiraEntrada;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : PrimeiraEntrada
    {
        #Atualizando no banco de dados
        $primeiraEntrada = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$primeiraEntrada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $primeiraEntrada;
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