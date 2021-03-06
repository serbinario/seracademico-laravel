<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository;
use Seracademico\Entities\Biblioteca\EmprestimoExemplar;
//use Carbon\Carbon;

class EmprestimoExemplarService
{
    /**
     * @var EmprestimoExemplarRepository
     */
    private $repository;

    /**
     * @param EmprestimoExemplarRepository $repository
     */
    public function __construct(EmprestimoExemplarRepository $repository)
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
        $emprestimoExemplar = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$emprestimoExemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $emprestimoExemplar;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : EmprestimoExemplar
    {
        #Salvando o registro pincipal
        $emprestimoExemplar =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$emprestimoExemplar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $emprestimoExemplar;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : EmprestimoExemplar
    {
        #Atualizando no banco de dados
        $emprestimoExemplar = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$emprestimoExemplar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $emprestimoExemplar;
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