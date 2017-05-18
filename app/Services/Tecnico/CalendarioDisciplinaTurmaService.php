<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Entities\Tecnico\AlunoFrequencia;
use Seracademico\Entities\Tecnico\AlunoNota;
use Seracademico\Entities\Tecnico\TurmaDisciplina;
use Seracademico\Repositories\Tecnico\AlunoRepository;
use Seracademico\Repositories\Tecnico\CalendarioDisciplinaTurmaRepository;
use Seracademico\Entities\Tecnico\CalendarioDisciplinaTurma;

class CalendarioDisciplinaTurmaService
{
    /**
     * @var CalendarioDisciplinaTurmaRepository
     */
    private $repository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param CalendarioDisciplinaTurmaRepository $repository
     */
    public function __construct(CalendarioDisciplinaTurmaRepository $repository,
                                AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
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
        $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $calendarioTurma = $this->repository->create($data);
        $turmaDisciplina = \DB::table('fac_turmas_disciplinas')
            ->select('turma_id', 'disciplina_id')
            ->where('id', $calendarioTurma->turma_disciplina_id)->get();

        # Recuperando todos os alunos
        $alunos = $this->alunoRepository->all();

        # Percorrendo todos os alunos
        foreach ($alunos as $aluno) {

            # Recuperando o ultimo currículo
            $curriculo = $aluno->curriculos()->get()->last();

            # Verificando se o currículo existe
            if($curriculo) {
                # Recuperando a ultima turma
                $turma = $curriculo->pivot->turmas()->get()->last();

                # Verificando se a turma existe
                if($turma && $turma->id == $turmaDisciplina[0]->turma_id) {
                    # Filtrando se o aluno possui nota cadastrada
                    $nota = $turma->pivot->notas()->get()->filter(function ($nota) use ($turmaDisciplina) {
                        return $nota->disciplina_id == $turmaDisciplina[0]->disciplina_id;
                    });

                    # Verificando e salvando nota
                    if(count($nota) == 0) {
                        # Salvando a nota
                        $turma->pivot->notas()
                            ->save(new AlunoNota([
                                'disciplina_id'  => $turmaDisciplina[0]->disciplina_id,
                                'situacao_nota_id' => 10,
                                'turma_id' => $turma->id
                            ]));

                        # Recuperando a nota
                        $nota = $turma->pivot->notas()->get()->last();
                    } else {
                        # Recuperando a ultima nota
                        $nota = $nota->last();
                    }

                    # Salvando a frequÊncia
                    $nota->frequencias()->save(new AlunoFrequencia(['calendario_id' => $calendarioTurma->id]));
                }
            }
        }

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
     * @return CalendarioDisciplinaTurma
     * @throws \Exception
     */
    public function update(array $data, int $id) : CalendarioDisciplinaTurma
    {
        #Aplicação das regras de negócios
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