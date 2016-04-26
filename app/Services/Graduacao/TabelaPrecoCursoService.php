<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\PrecoCurso;
use Seracademico\Repositories\Graduacao\PrecoCursoRepository;

class TabelaPrecoCursoService
{
    /**
     * @var PrecoCursoRepository
     */
    private $repository;

    /**
     * @param PrecoCursoRepository $repository
     */
    public function __construct(PrecoCursoRepository $repository)
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
        $tipoPrecoCurso = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$tipoPrecoCurso) {
            throw new \Exception('Tabela de preços não encontrada!');
        }

        #retorno
        return $tipoPrecoCurso;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : PrecoCurso
    {
        # Aplicações das regras de negócio
        $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $tipoPrecoCurso =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$tipoPrecoCurso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $tipoPrecoCurso;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : PrecoCurso
    {
        #Atualizando no banco de dados
        $tipoPrecoCurso = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$tipoPrecoCurso) {
            throw new \Exception('Ocorreu um erro ao atualizar!');
        }

        #Retorno
        return $tipoPrecoCurso;
    }

    /**
     * @param $idPrecoCurso
     * @return bool
     * @throws \Exception
     */
    public function delete($idPrecoCurso)
    {
        #Recuperando o registro no banco de dados
        $tipoPrecoCurso = $this->repository->find($idPrecoCurso);

        #Verificando se o registro foi encontrado
        if(!$tipoPrecoCurso) {
            throw new \Exception('Tabela de preços não encontrada!');
        }

        # Deletando o registro
        $this->repository->delete($tipoPrecoCurso->id);

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
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::get();
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
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }

        #Retorno
        return $data;
    }
}