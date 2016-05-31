<?php

namespace Seracademico\Services;

use Seracademico\Entities\ItemParametro;
use Seracademico\Repositories\ItemParametroRepository;
use Seracademico\Repositories\ParametroRepository;
use Seracademico\Entities\Parametro;
//use Carbon\Carbon;

class ParametroService
{
    /**
     * @var ParametroRepository
     */
    private $repository;

    /**
     * @var ItemParametroRepository
     */
    private $itemRepository;

    /**
     * @param ParametroRepository $repository
     * @param ItemParametroRepository $itemRepository
     */
    public function __construct(ParametroRepository $repository, ItemParametroRepository $itemRepository)
    {
        $this->repository     = $repository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $parametro = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$parametro) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $parametro;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Parametro
    {
        #Salvando o registro pincipal
        $parametro =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$parametro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $parametro;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Parametro
    {
        #Atualizando no banco de dados
        $parametro = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$parametro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $parametro;
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
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findItem($id)
    {
        #Recuperando o registro no banco de dados
        $item = $this->itemRepository->find($id);

        #Verificando se o registro foi encontrado
        if(!$item) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $item;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateItem(array $data, int $id) : ItemParametro
    {
        #Atualizando no banco de dados
        $item = $this->itemRepository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$item) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $item;
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteItem($id)
    {
        return $this->itemRepository->delete($id);
    }

}