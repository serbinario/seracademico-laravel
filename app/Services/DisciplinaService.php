<?php

namespace Seracademico\Services;

use Seracademico\Repositories\DisciplinaRepository;
use Seracademico\Entities\Disciplina;

class DisciplinaService
{
    /**
     * @var DisciplinaRepository
     */
    private $repository;

    /**
     * @param DisciplinaRepository $repository
     */
    public function __construct(DisciplinaRepository $repository)
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
        $disciplina = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$disciplina) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $disciplina;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Disciplina
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #Salvando o registro pincipal
        $disciplina =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$disciplina) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $disciplina;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Disciplina
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #Atualizando no banco de dados
        $disciplina = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$disciplina) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $disciplina;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
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