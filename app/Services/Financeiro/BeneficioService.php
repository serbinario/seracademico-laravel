<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\BeneficioRepository;
use Seracademico\Entities\Financeiro\Beneficio;
//use Carbon\Carbon;

class BeneficioService
{
    /**
     * @var BeneficioRepository
     */
    private $repository;

    /**
     * @param BeneficioRepository $repository
     */
    public function __construct(BeneficioRepository $repository)
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
        #Recuperando o registro no beneficio de dados
        $beneficio = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$beneficio) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $beneficio;
    }

    /**
     * @param array $data
     * @return Beneficio
     * @throws \Exception
     */
    public function store(array $data) : Beneficio
    {
        # Regras de negócio
        $this->tratamentoCampos($data);

        # Tratamento das taxas
        $taxas = $data['taxas'];
        unset($data['taxas']);

        #Salvando o registro pincipal
        $beneficio =  $this->repository->create($data);

        # Salvando as taxas
        $beneficio->taxas()->attach($taxas);

        #Verificando se foi criado no beneficio de dados
        if(!$beneficio) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $beneficio;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Beneficio
     * @throws \Exception
     */
    public function update(array $data, int $id) : Beneficio
    {
        # Regras de negócio
        $this->tratamentoCampos($data);

        # Tratamento das taxas
        $taxas = $data['taxas'];
        unset($data['taxas']);

        #Atualizando no beneficio de dados
        $beneficio = $this->repository->update($data, $id);

        # Salvando as taxas
        $beneficio->taxas()->attach($taxas);

        #Verificando se foi atualizado no beneficio de dados
        if(!$beneficio) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $beneficio;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function destroy($id)
    {
        #Recuperando o registro no beneficio de dados
        $beneficio = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$beneficio) {
            throw new \Exception('Empresa não encontrada!');
        }

        # Removendo as dependências
        $beneficio->taxas()->detach();
        
        # Removendo o benefício
        $this->repository->delete($id);

        # Retorno
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