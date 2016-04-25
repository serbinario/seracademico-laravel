<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\SedeRepository;
use Seracademico\Entities\Sede;

class SedeService
{
    /**
     * @var SedeRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @param SedeRepository $repository
     * @param EnderecoRepository $enderecoRepository
     */
    public function __construct(SedeRepository $repository, EnderecoRepository $enderecoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $sede = $this->repository->with('endereco.bairro.cidade.estado')->find($id);

        #Verificando se o registro foi encontrado
        if(!$sede) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $sede;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Sede
    {
        #Criando no banco de dados
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #setando o endereco
        $data['endereco_id'] = $endereco->id;

        #Salvando o registro pincipal
        $sede =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$sede) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $sede;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Sede
    {
        #Atualizando no banco de dados
        $sede     = $this->repository->update($data, $id);
        $endereco = $this->enderecoRepository->update($data['endereco'], $sede->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$sede || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $sede;
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