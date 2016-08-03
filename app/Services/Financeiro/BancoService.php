<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\BancoRepository;
use Seracademico\Entities\Financeiro\Banco;
//use Carbon\Carbon;

class BancoService
{
    /**
     * @var BancoRepository
     */
    private $repository;

    /**
     * @param BancoRepository $repository
     */
    public function __construct(BancoRepository $repository)
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
        $banco = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$banco) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $banco;
    }

    /**
     * @param array $data
     * @return Banco
     * @throws \Exception
     */
    public function store(array $data) : Banco
    {
        # Regras de negócio
        $this->tratamentoCampos($data);
        
        #Salvando o registro pincipal
        $banco =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$banco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $banco;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Banco
     * @throws \Exception
     */
    public function update(array $data, int $id) : Banco
    {
        # Regras de negócio
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $banco = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$banco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $banco;
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
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }
}