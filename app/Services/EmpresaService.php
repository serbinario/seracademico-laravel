<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EmpresaRepository;
use Seracademico\Entities\Empresa;
use Seracademico\Repositories\EnderecoRepository;

class EmpresaService
{
    /**
     * @var EmpresaRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @param EmpresaRepository $repository
     */
    public function __construct(EmpresaRepository $repository, EnderecoRepository $enderecoRepository)
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
        $empresa = $this->repository->with('endereco')->find($id);

        #Verificando se o registro foi encontrado
        if(!$empresa) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $empresa;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isExists()
    {
        #Recupera a empresas
        $result = $this->repository->all();

        #verifica se existe mais de uma empresa cadastrada
        if(count($result) > 1) {
            throw new Exception('Existe mais de uma empresa cadastrada, informe ao responsável do sistema!');
        }

        #Verifica se existe uma empresa cadastrada
        if(count($result) > 0) {
            #retorno caso exista uma empresa cadastrada
            return $result[0];
        }

        #retorno caso não exista uma empresa cadastrada
        return false;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Empresa
    {
        #Criando no banco de dados
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #setando o endereco
        $data['endereco_id'] = $endereco->id;

        #Salvando o registro pincipal
        $empresa =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$empresa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $empresa;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Empresa
    {
        #Atualizando no banco de dados
        $empresa  = $this->repository->update($data, $id);
        $endereco = $this->enderecoRepository->update($data['endereco'], $empresa->endereco->id);


        #Verificando se foi atualizado no banco de dados
        if(!$empresa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $empresa;
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