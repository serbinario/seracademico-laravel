<?php

namespace Seracademico\Services;

use Seracademico\Repositories\CalendarioDisciplinaTurmaRepository;
use Seracademico\Entities\CalendarioDisciplinaTurma;
use Carbon\Carbon;

class CalendarioDisciplinaTurmaService
{
    /**
     * @var CalendarioDisciplinaTurmaRepository
     */
    private $repository;

    /**
     * @param CalendarioDisciplinaTurmaRepository $repository
     */
    public function __construct(CalendarioDisciplinaTurmaRepository $repository)
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
        $calendarioTurma = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$calendarioTurma) {
            throw new \Exception('Tipo de avaliação não encontrada!');
        }

        #retorno
        return $calendarioTurma;
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findByField($field, $value)
    {
        return $this->repository->findByField($field, $value);
    }

    /**
     * @param array $data
     * @return CalendarioDisciplinaTurma
     * @throws \Exception
     */
    public function store(array $data) : CalendarioDisciplinaTurma
    {
        #Aplicação das regras de negócios
        $this->tratamentoDatas($data);
        $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $calendarioTurma =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$calendarioTurma) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendarioTurma;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : CalendarioDisciplinaTurma
    {
        #Aplicação das regras de negócios
        $this->tratamentoDatas($data);
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $calendarioTurma = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$calendarioTurma) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendarioTurma;
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
    public function tratamentoDatas(array &$data) : array
    {
        #tratando as datas
        $data['data']         = $data['data'] ? Carbon::createFromFormat("d/m/Y", $data['data']) : "";
        $data['data_final']   = $data['data_final'] ? Carbon::createFromFormat("d/m/Y", $data['data_final']) : "";
        $data['hora_inicial'] = $data['hora_inicial'] ? Carbon::createFromFormat("H:i:s", $data['hora_inicial']) : "";
        $data['hora_final']   = $data['hora_final'] ? Carbon::createFromFormat("H:i:s", $data['hora_final']) : "";

        #retorno
        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoCampos(array &$data) : array
    {
        $data['professor_id'] = $data['professor_id'] == "" ? null : $data['professor_id'];
        $data['sala_id']      = $data['sala_id'] == "" ? null : $data['sala_id'];

        #retorno
        return $data;
    }
}