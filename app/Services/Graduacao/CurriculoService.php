<?php

namespace Seracademico\Services\Graduacao;

use Illuminate\Support\Facades\DB;
use Seracademico\Repositories\Graduacao\CurriculoRepository;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Repositories\Graduacao\CursoRepository;
use Seracademico\Repositories\Graduacao\DisciplinaRepository;
use Seracademico\Repositories\Graduacao\PivotCurriculoDisciplinaRepository;

class CurriculoService
{
    /**
     * @var CurriculoRepository
     */
    private $repository;

    /**
     * @var DisciplinaRepository
     */
    private $disciplinaRepository;

    /**
     * @param CurriculoRepository $repository
     * @param DisciplinaRepository $disciplinaRepository
     * @param PivotCurriculoDisciplinaRepository $pivotCurriculoDisciplinaRepository
     */
    public function __construct(
        CurriculoRepository $repository,
        DisciplinaRepository $disciplinaRepository)
    {
        $this->repository           = $repository;
        $this->disciplinaRepository = $disciplinaRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $curriculo = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$curriculo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 1;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Salvando o registro pincipal
        $curriculo =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 1;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Atualizando no banco de dados
        $curriculo = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }


    /**
     * @param array $models
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
            $model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id']);
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
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
    private function tratamentoCurriculoAtivo(array &$data): array
    {
        #Verificando se a condição é válida
        if($data['ativo'] == 1 && isset($data['curso_id'])) {
            #Recuperando o(s) currículo(s) ativo(s)
            $rows = $this->repository->getCurriculoAtivo($data['curso_id']);

            #Varrendo o array
            foreach($rows as $row) {
                $curriculo = $this->repository->find($row->id);

                $curriculo->ativo = 0;
                $curriculo->save();
            }
        }

        #retorno
        return $data;
    }

    /**
     * @param $idCurriculoDisciplina
     */
    public function disciplinaFind($idDisciplina, $idCurriculo)
    {
        # Recuperando a disciplina
        $curriculo       = $this->repository->find($idCurriculo);
        $disciplina      = $curriculo->disciplinas()->find($idDisciplina);

        # Verificando a existência da disciplina
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Disciplina não encontrada!");
        }

        # Recuperando o pivot
        $pivotDisciplina = $disciplina->pivot;

        # Retorno
        return ['model' => $pivotDisciplina, 'nomeDisciplina' => $disciplina->nome];
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function disciplinaStore(array $data)
    {
        # Recuperando o currículo
        $curriculo     = $this->repository->find($data['curriculo_id']);
        $objDisciplina = $this->disciplinaRepository->find($data['disciplina_id']);

        # Verificando se o currículo foi recuperado
        if(!$curriculo && !$objDisciplina) {
            throw new \Exception("Curriculo não encontrado!");
        }

        # atrelando os valores
        $curriculo->disciplinas()->attach($objDisciplina,
            [
                'periodo' => $data['periodo'],
                'carga_horaria_total' => $data['carga_horaria_total'],
                'carga_horaria_teorica' => $data['carga_horaria_teorica'],
                'carga_horaria_pratica' => $data['carga_horaria_pratica'],
                'qtd_credito' => $data['qtd_credito'],
                'qtd_faltas'  => $data['qtd_faltas']
            ]
        );

        # Contadores úteis
        $countPre = 0;
        $countCos = 0;

        # Varrendo o array
        foreach ($curriculo->disciplinas as $disciplina) {
            if($disciplina->id == $objDisciplina->id) {
                # Tratamento pre disciplina
                if(isset($data['pre_disciplina']) && count($data['pre_disciplina']) > 0) {
                    foreach ($data['pre_disciplina'] as $pre) {
                        $disciplina->pivot->disciplinasPreRequisitos()->attach($pre, ['index' => ++$countPre]);
                    }
                }

                # Tratamento co disciplina
                if(isset($data['co_disciplina']) && count($data['co_disciplina']) > 0) {
                    foreach ($data['co_disciplina'] as $cos) {
                        $disciplina->pivot->disciplinasCoRequisitos()->attach($cos, ['index' => ++$countCos]);
                    }
                }
            }
        }

        # Retorno
        return true;
    }

    /**
     * @param $idCurriculo
     * @param $idDisciplina
     * @throws \Exception
     */
    public function disciplinaDelete($data)
    {
        # Recuperando o currículo
        $curriculo  = $this->repository->find($data['idCurriculo']);
        $disciplina = $this->disciplinaRepository->find($data['idDisciplina']);

        # Verificando se o currículo foi recuperado
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Curriculo não encontrado!");
        }

        #Deletando as dependências
        foreach ($curriculo->disciplinas as $objDisciplina) {
            if($disciplina->id === $objDisciplina->id) {
                $objDisciplina->pivot->disciplinasPreRequisitos()->detach();
                $objDisciplina->pivot->disciplinasCoRequisitos()->detach();
            }
        }

        #Disvinculando a disciplina do currículo
        $curriculo->disciplinas()->detach($disciplina->id);

        #Retorno
        return true;
    }

    /**
     * @param $idDisciplina
     * @param $idCurriculo
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function disciplinaUpdate($idDisciplina, $idCurriculo, $data)
    {
        # Recuperando a disciplina
        $curriculo       = $this->repository->find($idCurriculo);
        $disciplina      = $curriculo->disciplinas()->find($idDisciplina);

        # Verificando a existência da disciplina
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Disciplina não encontrada!");
        }

        # Processo de atualização do pivot
        $disciplina->pivot->periodo = $data['periodo'];
        $disciplina->pivot->carga_horaria_total   = $data['carga_horaria_total'];
        $disciplina->pivot->carga_horaria_teorica = $data['carga_horaria_teorica'];
        $disciplina->pivot->carga_horaria_pratica = $data['carga_horaria_pratica'];
        $disciplina->pivot->qtd_credito           = $data['qtd_credito'];
        $disciplina->pivot->qtd_faltas            = $data['qtd_faltas'];
        $disciplina->pivot->disciplinasPreRequisitos()->detach();
        $disciplina->pivot->disciplinasCoRequisitos()->detach();

        # Contadores úteis
        $countPre = 0;
        $countCos = 0;

        # Cadastrando as disciplinas de prerequisitos
        if(isset($data['pre_disciplina']) && count($data['pre_disciplina']) > 0) {
            foreach ($data['pre_disciplina'] as $pre) {
                $disciplina->pivot->disciplinasPreRequisitos()->attach($pre, ['index' => ++$countPre]);
            }
        }

        # Cadastrando as disciplinas de costrquisitos
        if(isset($data['co_disciplina']) && count($data['co_disciplina']) > 0) {
            foreach ($data['co_disciplina'] as $cos) {
                $disciplina->pivot->disciplinasCoRequisitos()->attach($cos, ['index' => ++$countCos]);
            }
        }

        #Salvando mudanças
        $disciplina->pivot->save();

        #retorno
        return true;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getDisciplina($id)
    {
        #Recuperando o registro no banco de dados
        $disciplina = $this->disciplinaRepository->find($id);

        #Verificando se o registro foi encontrado
        if(!$disciplina) {
            throw new \Exception('Disciplina não encontrada!');
        }

        #retorno
        return $disciplina;
    }
}