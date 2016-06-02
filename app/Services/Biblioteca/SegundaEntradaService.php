<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\SegundaEntradaRepository;
use Seracademico\Entities\Biblioteca\SegundaEntrada;
//use Carbon\Carbon;

class SegundaEntradaService
{
    /**
     * @var SegundaEntradaRepository
     */
    private $repository;

    /**
     * @param SegundaEntradaRepository $repository
     */
    public function __construct(SegundaEntradaRepository $repository)
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
        $segundaEntrada = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$segundaEntrada) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $segundaEntrada;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : SegundaEntrada
    {
        #Salvando o registro pincipal
        $segundaEntrada =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$segundaEntrada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $segundaEntrada;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : SegundaEntrada
    {
        #Atualizando no banco de dados
        $segundaEntrada = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$segundaEntrada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $segundaEntrada;
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