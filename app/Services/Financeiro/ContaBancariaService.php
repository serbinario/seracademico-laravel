<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Entities\Financeiro\ContaBancaria;

class ContaBancariaService
{
    /**
     * @var ContaBancariaRepository
     */
    private $repository;

    /**
     * @param ContaBancariaRepository $repository
     */
    public function __construct(ContaBancariaRepository $repository)
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
        # Relacionamentos
        $relacionamentos = [
            'banco'
        ];

        #Recuperando o registro no banco de dados
        $contaBancaria = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$contaBancaria) {
            throw new \Exception('Conta bancária não encontrada!');
        }

        #retorno
        return $contaBancaria;
    }


    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function findIn(array $data)
    {
        #Recuperando os registros no banco de dados
        $contaBancarias = $this->repository->findWhereIn('id', $data);

        #Verificando se o registro foi encontrado
        if(!$contaBancarias) {
            throw new \Exception('ContaBancarias não encontradas!');
        }

        #retorno
        return $contaBancarias;
    }

    /**
     * @param array $data
     * @return ContaBancaria
     * @throws \Exception
     */
    public function store(array $data) : ContaBancaria
    {   
        #Salvando o registro pincipal
        $contaBancaria =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$contaBancaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $contaBancaria;
    }

    /**
     * @param array $data
     * @param int $id
     * @return ContaBancaria
     * @throws \Exception
     */
    public function update(array $data, int $id) : ContaBancaria
    {
        #Atualizando no banco de dados
        $contaBancaria = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$contaBancaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $contaBancaria;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #Atualizando no banco de dados
        $contaBancaria = $this->repository->find($id);

        #Verificando se foi atualizado no banco de dados
        if(!$contaBancaria) {
            throw new \Exception('ContaBancaria não encontrada!');
        }

        # Removendo a contaBancaria
        $this->repository->delete($contaBancaria->id);

        #Retorno
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
}