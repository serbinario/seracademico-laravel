<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\DiarioAulaRepository;
use Seracademico\Entities\PosGraduacao\DiarioAula;

class DiarioAulaService
{
    /**
     * @var DiarioAulaRepository
     */
    private $repository;

    /**
     * @param DiarioAulaRepository $repository
     */
    public function __construct(DiarioAulaRepository $repository)
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
        $diarioAula = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$diarioAula) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $diarioAula;
    }

    /**
     * @param array $data
     * @return DiarioAula
     * @throws \Exception
     */
    public function store(array $data) : DiarioAula
    {
        # aplicação das regras de negócio
        $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $diarioAula =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$diarioAula) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Verificando se a conteúdo a ser cadastrado
        if(isset($data['conteudos']) && count($data['conteudos']) > 0) {
            # Vinculando os conteúdos
            $diarioAula->conteudos()->attach($data['conteudos']);
        }

        #Retorno
        return $diarioAula;
    }

    /**
     * @param array $data
     * @param int $id
     * @return DiarioAula
     * @throws \Exception
     */
    public function update(array $data, int $id) : DiarioAula
    {
        # aplicação das regras de negócio
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $diarioAula = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$diarioAula) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $diarioAula;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Recuperando o registro no banco de dados
        $diarioAula = $this->repository->find($id);

        #Verificando se foi atualizado no banco de dados
        if(!$diarioAula) {
            throw new \Exception('Diário de aula não encontrado!');
        }

        # Removendo todos as pendências
        $diarioAula->conteudos()->detach();

        # Remvendo o registro do banco
        $this->repository->delete($diarioAula->id);

        #Retorno
        return $diarioAula;
    }


    /**
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
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

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
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