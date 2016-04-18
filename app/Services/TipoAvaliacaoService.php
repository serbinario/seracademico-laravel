<?php

namespace Seracademico\Services;

use Seracademico\Repositories\TipoAvaliacaoRepository;
use Seracademico\Entities\TipoAvaliacao;

class TipoAvaliacaoService
{
    /**
     * @var TipoAvaliacaoRepository
     */
    private $repository;

    /**
     * @param TipoAvaliacaoRepository $repository
     */
    public function __construct(TipoAvaliacaoRepository $repository)
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
        $TipoAvaliacao = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$TipoAvaliacao) {
            throw new \Exception('Tipo de avaliação não encontrada!');
        }

        #retorno
        return $TipoAvaliacao;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : TipoAvaliacao
    {
        #Salvando o registro pincipal
        $TipoAvaliacao =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$TipoAvaliacao) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $TipoAvaliacao;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : TipoAvaliacao
    {
        #Atualizando no banco de dados
        $TipoAvaliacao = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$TipoAvaliacao) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $TipoAvaliacao;
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
}