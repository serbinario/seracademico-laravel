<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\PlanoAulaRepository;
use Seracademico\Entities\Graduacao\PlanoAula;

class PlanoAulaService
{
    /**
     * @var PlanoAulaRepository
     */
    private $repository;

    /**
     * @param PlanoAulaRepository $repository
     */
    public function __construct(PlanoAulaRepository $repository)
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
        $planoAula = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$planoAula) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $planoAula;
    }

    /**
     * @param array $data
     * @return PlanoAula
     * @throws \Exception
     */
    public function store(array $data) : PlanoAula
    {
        # Regras de negócio
        $this->tratamentoCampos($data);
        
        #Salvando o registro pincipal
        $planoAula =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$planoAula) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Verificação de existência
        if(isset($data['conteudos'])) {
            # Vinculando os conteúdos
            $planoAula->conteudos()->attach($data['conteudos']);
        }

        #Retorno
        return $planoAula;
    }

    /**
     * @param array $data
     * @param int $id
     * @return PlanoAula
     * @throws \Exception
     */
    public function update(array $data, int $id) : PlanoAula
    {
        # Regras de negócio
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $planoAula = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$planoAula) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoAula;
    }


    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #Atualizando no banco de dados
        $planoAula = $this->repository->find($id);


        #Verificando se foi encontrado
        if(!$planoAula) {
            throw new \Exception('Plano de aula não encontrado!');
        }

        # removendo o plano de aula
        $planoAula->conteudos()->detach();
        $this->repository->delete($planoAula->id);
        
        #Retorno
        return $planoAula;
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
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->lists('nome', 'id');
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