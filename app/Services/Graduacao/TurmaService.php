<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\CurriculoRepository;
use Seracademico\Repositories\Graduacao\DisciplinaRepository;
use Seracademico\Repositories\Graduacao\TurmaRepository;
use Seracademico\Entities\Graduacao\Turma;
use Carbon\Carbon;

class TurmaService
{
    /**
     * @var TurmaRepository
     */
    private $repository;

    /**
     * @var CurriculoRepository
     */
    private $curriculoRepository;

    /**
     * @var DisciplinaRepository
     */
    private $disciplinaRepository;

    /**
     * @param TurmaRepository $repository
     * @param CurriculoRepository $curriculoRepository
     * @param DisciplinaRepository $disciplinaRepository
     */
    public function __construct(
        TurmaRepository $repository,
        CurriculoRepository $curriculoRepository,
        DisciplinaRepository $disciplinaRepository)
    {
        $this->repository           = $repository;
        $this->curriculoRepository  = $curriculoRepository;
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
        $turma = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$turma) {
            throw new \Exception('Turma não encontrada!');
        }

        #retorno
        return $turma;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Turma
    {
        #Aplicação das regras de negócios
        $data['tipo_nivel_sistema_id'] = 1;
        $this->tratamentoDoCurso($data);

        #Salvando o registro pincipal
        $turma =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$turma) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Aplicação das regras de negócios
        $this->tratamentoDisciplinas($turma);

        #Retorno
        return $turma;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Turma
    {
        # Aplicação das regras de negócios
        $data['tipo_nivel_sistema_id'] = 1;
        $this->tratamentoDoCurso($data, $id);

        # Verifica se é o mesmo currículo (false), se não for, se pode ser alterado (true).
        # Se não poder ser alterado lançará uma exception.
        $resultTratamentoCurriculo = $this->tratamentoCurriculo($id, $data);

        # Atualizando no banco de dados
        $turma = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if (!$turma) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Verifica se é um currículo diferente.
        # true -> currículo diferente e válido para ser alterado
        # false -> currículo igual
        if ($resultTratamentoCurriculo) {
            # Aplicação das regras de negócios
            $this->tratamentoDisciplinasUpdate($turma);
        }

        # Retorno
        return $turma;
    }

    /**
     * @param $idTurma
     * @return array
     * @throws \Exception
     */
    public function getDisciplinasDiferentOfCurriculo($idTurma)
    {
        #Recuperando a turma
        $turma = $this->repository->find($idTurma);

        #Verificando se a turma foi recuperada
        if (!$turma) {
            throw new \Exception('Turma não encontrada!');
        }

        #Array de retorno
        $disciplinas = [];

        #Recupernando as disciplinas
        $disciplinasTurma     = $turma->disciplinas->lists(['id'])->toArray();
        $disciplinasCurriculo = $turma->curriculo->disciplinas;

        #Algorítmo para verificar a existência das disciplinas na turma
        foreach ($disciplinasCurriculo as $disciplinaCurriculo) {
            #Verificando qual discipplina não está no array das disciplina da turma
            if( !in_array($disciplinaCurriculo->id, $disciplinasTurma)) {
                $disciplinas[] = $disciplinaCurriculo;
            }
        }

        #Retorno
        return $disciplinas;
    }


    /**
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
                if(count($expressao) > 1) {
                    switch (count($expressao)) {
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
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function tratamentoDoCurso(&$data, $id = "")
    {
        #Verificando se foi passado o curso
        if($data['curso_id']) {
            #Recuperando o currículo ativo
            $curriculo = $this->curriculoRepository->getCurriculoAtivo($data['curso_id']);

            # Verificando se existe currículo
            if(!$curriculo) {
                throw new \Exception("Não existe currículo ativo vinculado a esse curso.");
            }

            #verificando se foi passado o id (caso seja update)
            if($id) {
                #Recuperando o objeto turma do banco de dados
                $objTurmaBanco      = $this->repository->find($id);
                $objCurriculoUpdate = $this->curriculoRepository->find($curriculo[0]->id);

                # Verificando se  o curso do currículo do banco
                # é o mesmo do currículo passado
                if($objTurmaBanco->curriculo->curso->id == $objCurriculoUpdate->curso->id) {
                    #Permanecendo o currículo do banco de dados (Que já estava vinculado na turma)
                    $data['curriculo_id'] = $objTurmaBanco->curriculo->id;

                    #retorno
                    return false;
                }
            }

            #Verificando se existe o currículo ativo
            if(count($curriculo) > 0) {
                $data['curriculo_id'] = $curriculo[0]->id;
                unset($data['curso_id']);
            } else {
                throw new \Exception("Não existe currículo ativo para esse curso!");
            }
        }

        #retorno
        return $data;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws \Exception
     */
    private function tratamentoCurriculo($id, $data)
    {
        #Recuperando o objeto turma do banco de dados
        $objTurmaBanco = $this->repository->find($id);

        #Verificando se é o mesmo currículo
        if($objTurmaBanco->curriculo_id == $data['curriculo_id']) {
            #retorno
            return false;
        }

        #percorrendo as disciplinas
        foreach ($objTurmaBanco->disciplinas as $disciplina) {
            if(count($disciplina->pivot->calendarios) > 0) {
                throw new \Exception("Já existe calendários para a esse curso,
                 se quiser continuar com a operação deverá deletar os calendários criados para esse curso!");
            }
        }


        #retorno
        return true;
    }

    /**
     * @param Turma $turma
     * @throws \Exception
     */
    private function tratamentoDisciplinas(Turma $turma)
    {
        try {
            #Verificando se disciplinas vinculadas ao currículo
            if(!count($turma->curriculo->disciplinas) > 0) {
                #retorno se não tiver disciplinas vinculadas ao currículo
                return false;
            }

            #percorrendo as disciplinas
            foreach ($turma->curriculo->disciplinas as $disciplina) {
                if($disciplina->pivot->periodo == $turma->periodo) {
                    $turma->disciplinas()->attach($disciplina);
                }
            }

            #Salvando no as disciplinas
            $turma->save();

            #Retorno se tudo der certo
            return true;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Turma $turma
     * @return bool
     * @throws \Exception
     */
    private function tratamentoDisciplinasUpdate(Turma $turma)
    {
        #Deleta todas as disciplinas vinculadas a essa turma
        $turma->disciplinas()->detach();

        #retorno
        return $this->tratamentoDisciplinas($turma);
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function incluirDisciplina(array $data) : bool
    {
        # Validando a requisição
        if(!(isset($data['disciplina_id']) && is_numeric($data['disciplina_id'])) &&
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Parametros inválidos");
        }

        # Recuperando os parametros da requisição
        $idTurma      = $data['idTurma'];
        $idDisciplina = $data['disciplina_id'];
       // $idEletiva    = (isset($data['eletiva_id']) &&  is_numeric($data['eletiva_id'])) ? $data['eletiva_id'] : null;

        # Recuperando a turma e a disciplina
        $objTurma      = $this->repository->find($idTurma);
        $objDisciplina = $this->disciplinaRepository->find($idDisciplina);
        //$objEletiva    = $this->disciplinaRepository->find($idEletiva);

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && !$objDisciplina) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        #Incluindo e salvando a disciplina
        $objTurma->disciplinas()->attach($objDisciplina->id);
        $objTurma->save();

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function removerDisciplina(array $data)
    {
        # Validando a requisição
        if(!(isset($data['idDisciplina']) && is_numeric($data['idDisciplina'])) &&
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Parametros inválidos");
        }

        # Recuperando os parametros da requisição
        $idTurma      = $data['idTurma'];
        $idDisciplina = $data['idDisciplina'];

        # Recuperando a turma e a disciplina
        $objTurma      = $this->repository->find($idTurma);
        $objDisciplina = $this->disciplinaRepository->find($idDisciplina);

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && !$objDisciplina) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        #Incluindo e salvando a disciplina
        $objTurma->disciplinas()->detach($objDisciplina->id);
        $objTurma->save();

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function incluirHorario(array $data) : bool
    {
        # Validando a requisição
        if(!(isset($data['disciplina_id']) && is_numeric($data['disciplina_id'])) &&
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Parametros inválidos");
        }

        #Tratamento dos campos
        $this->tratamentoCampos($data);

        # Recuperando os parametros da requisição
        $idTurma      = $data['idTurma'];
        $idDisciplina = $data['disciplina_id'];

        # Removendo o idTurma do array
        unset($data['idTurma']);

        # Recuperando a turma e a disciplina
        $objTurma      = $this->repository->find($idTurma);
        $objDisciplina = $this->disciplinaRepository->find($idDisciplina);

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && !$objDisciplina) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        #Incluindo e salvando a disciplina
        $disciplina = $objTurma->disciplinas()->find($objDisciplina->id);
        $pivot      = $disciplina->pivot;

        # Salvando o horário
        $pivot->horarios()->create($data);

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function removerHorario(array $data)
    {
        # Validando a requisição
        if(!(isset($data['idDia']) && is_numeric($data['idDia'])) &&
            !(isset($data['idHora']) && is_numeric($data['idHora'])) &&
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Parametros inválidos");
        }

        # Recuperando os parametros da requisição
        $idTurma = $data['idTurma'];
        $idDia   = $data['idDia'];
        $idHora  = $data['idHora'];

        # Recuperando a turma e a disciplina
        $objTurma   = $this->repository->find($idTurma);
        $resultId   = \DB::table('fac_horarios')
                            ->select(['fac_turmas_disciplinas.disciplina_id', 'fac_horarios.id'])
                            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                            ->where('fac_turmas.id', $idTurma)
                            ->where('fac_horarios.dia_id', $idDia)
                            ->where('fac_horarios.hora_id', $idHora)
                            ->get();


        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && count($resultId) == 0) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        #Recuperando o pivot e remocvendo o horário
        $disciplina  = $objTurma->disciplinas()->find($resultId[0]->disciplina_id);
        $pivot       = $disciplina->pivot;
        $horario     = $pivot->horarios()->find($resultId[0]->id);

        # Removendo o horário
        $horario->delete();

        # Salvando mudanças
        $objTurma->save();

        #Retorno
        return true;
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