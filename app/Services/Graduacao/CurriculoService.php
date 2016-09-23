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
     * @return Curriculo
     * @throws \Exception
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
     * @return Curriculo
     * @throws \Exception
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
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
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
     * @param $idDisciplina
     * @param $idCurriculo
     * @return array
     * @throws \Exception
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
        return [
            'model' => $pivotDisciplina,
            'nomeDisciplina' => $disciplina->nome,
            'codigoDisciplina' => $disciplina->codigo
        ];
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function disciplinaStore(array $data)
    {
        # Regras de negócios
        $this->tratamentoCampos($data);

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
                'carga_horaria_total'   => $data['carga_horaria_total'],
                'carga_horaria_teorica' => $data['carga_horaria_teorica'],
                'carga_horaria_pratica' => $data['carga_horaria_pratica'],
                'qtd_credito' => $data['qtd_credito'],
                'qtd_faltas'  => $data['qtd_faltas'],
                'pre_requisito_1_id' => $data['pre_requisito_1_id'],
                'pre_requisito_2_id' => $data['pre_requisito_2_id'],
                'pre_requisito_3_id' => $data['pre_requisito_3_id'],
                'pre_requisito_4_id' => $data['pre_requisito_4_id'],
                'co_requisito_1_id'  => $data['co_requisito_1_id'],
            ]
        );

        # Retorno
        return true;
    }

    /**
     * @param $data
     * @return bool
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

        #Disvinculando a disciplina do currículo
        $curriculo->disciplinas()->detach($disciplina->id);

        #Retorno
        return true;
    }

    /**
     * @param $idDisciplina
     * @param $idCurriculo
     * @param $dados
     * @return bool
     * @throws \Exception
     */
    public function disciplinaUpdate($idDisciplina, $idCurriculo, $dados)
    {
        # Regras de negócios
        $this->tratamentoCampos($dados);

        # Recuperando a disciplina
        $curriculo       = $this->repository->find($idCurriculo);
        $disciplina      = $curriculo->disciplinas()->find($idDisciplina);

        # Verificando a existência da disciplina
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Disciplina não encontrada!");
        }

        #Salvando mudanças
        $disciplina->pivot->update($dados);

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

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function storeOpcaoEletiva(array $data)
    {
        # Validando os parâmetros de entrada
        if(!isset($data['semestre_eletiva_id']) && !isset($data['disciplina_eletiva_id'])) {
            throw new \Exception('Você deve informa o semestre e a disciplina');
        }

        # Validando os parâmetros de entrada interno
        if(!isset($data['curriculo_disciplina_id'])) {
            throw new \Exception('Parêmetros inválidos');
        }

        # Recuperando o id do curriculo e disciplina
        $rowCurriculoDisciplina = \DB::table('fac_curriculo_disciplina')
            ->select(['curriculo_id', 'disciplina_id'])
            ->where('id', $data['curriculo_disciplina_id'])->get();

        # Validando resultado da pesquisa
        if(count($rowCurriculoDisciplina) !== 1) {
            throw new \Exception('Disciplina eletiva não encontrada');
        }

        # Recuperando o curriculo
        $curriculo = $this->repository->find($rowCurriculoDisciplina[0]->curriculo_id);

        # Recuperando o semestre
        $semestre  = $curriculo->disciplinas()->find($rowCurriculoDisciplina[0]->disciplina_id)->pivot->semestres()->find($data['semestre_eletiva_id']);

        # Verificando se o semestre foi retornado
        if(!$semestre) {
            # Salvando o semestre da eletiva
            $curriculo->disciplinas()->find($rowCurriculoDisciplina[0]->disciplina_id)->pivot->semestres()->attach($data['semestre_eletiva_id']);
            $semestre  = $curriculo->disciplinas()->find($rowCurriculoDisciplina[0]->disciplina_id)->pivot->semestres()->find($data['semestre_eletiva_id']);
        }

        # Salvando a disciplina eletiva no semestre
        $semestre->pivot->disciplinasEletivas()->attach($data['disciplina_eletiva_id']);

        # Retorno
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteOpcaoEletiva(int $id)
    {
        # Recuperando o id do curriculo e disciplina
       \DB::table('fac_eletivas_disciplinas')
            ->select(['id'])
            ->where('id', $id)->delete();

        # Retorno
        return true;
    }
}