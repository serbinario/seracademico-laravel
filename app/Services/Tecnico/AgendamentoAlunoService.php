<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Repositories\Tecnico\AgendamentoAlunoRepository;
use Seracademico\Entities\Tecnico\AgendamentoAluno;

class AgendamentoAlunoService
{

    private $repository;

    public function __construct(AgendamentoAlunoRepository $repository)
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
        $resultado = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$resultado) {
            throw new \Exception('Modulo não encontrada!');
        }

        #retorno
        return $resultado;
    }

    /**
     * @param array $data
     * @return Modulo
     * @throws \Exception
     */
    public function store(array $data) : AgendamentoAluno
    {

        #Salvando o registro pincipal
        $resultado = $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$resultado) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $resultado;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);

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