<?php

namespace Seracademico\Services;

use Carbon\Carbon;
use Seracademico\Repositories\CursoRepository;
use Seracademico\Entities\Curso;

class CursoService
{
    /**
     * @var CursoRepository
     */
    private $repository;

    /**
     * @param CursoRepository $repository
     */
    public function __construct(CursoRepository $repository)
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
        $curso = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$curso) {
            throw new \Exception('Curso não encontrado!');
        }

        #retorno
        return $curso;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Curso
    {
        #Salvando o registro pincipal
        $curso =  $this->repository->create($this->tratamentoDatas($data));

        #Verificando se foi criado no banco de dados
        if(!$curso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curso;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Curso
    {
        #Atualizando no banco de dados
        $curso = $this->repository->update($this->tratamentoDatas($data), $id);

        #Verificando se foi atualizado no banco de dados
        if(!$curso) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curso;
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

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array $data) : array
    {
        #tratando as datas
        $data['data_decreto_rec']      = $data['data_decreto_rec'] ? Carbon::createFromFormat("d/m/Y", $data['data_decreto_rec']) : "";
        $data['data_dou_rec']          = $data['data_dou_rec'] ? Carbon::createFromFormat("d/m/Y", $data['data_dou_rec']) : "";
        $data['data_decreto_aut']      = $data['data_decreto_aut'] ? Carbon::createFromFormat("d/m/Y", $data['data_decreto_aut']) : "";
        $data['data_dou_aut']          = $data['data_dou_aut'] ? Carbon::createFromFormat("d/m/Y", $data['data_dou_aut']) : "";
        $data['data_matricula_inicio'] = $data['data_matricula_inicio'] ? Carbon::createFromFormat("d/m/Y", $data['data_matricula_inicio']) : "";
        $data['data_matricula_fim']    = $data['data_matricula_fim'] ? Carbon::createFromFormat("d/m/Y", $data['data_matricula_fim']) : "";
        $data['inicio_aula']           = $data['inicio_aula'] ? Carbon::createFromFormat("d/m/Y", $data['inicio_aula']) : "";
        $data['fim_aula']              = $data['fim_aula'] ? Carbon::createFromFormat("d/m/Y", $data['fim_aula']) : "";
        $data['vencimento_inicial']    = $data['vencimento_inicial'] ? Carbon::createFromFormat("d/m/Y", $data['vencimento_inicial']) : "";

        #retorno
        return $data;
    }
}