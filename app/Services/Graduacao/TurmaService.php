<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\HorarioDisciplinaTurma;
use Seracademico\Repositories\Graduacao\CurriculoRepository;
use Seracademico\Repositories\Graduacao\DisciplinaRepository;
use Seracademico\Repositories\Graduacao\HorarioDisciplinaTurmaRepository;
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
     * @var HorarioDisciplinaTurmaRepository
     */
    private $horarioDisciplinaTurmaRepository;

    /**
     * @param TurmaRepository $repository
     * @param CurriculoRepository $curriculoRepository
     * @param DisciplinaRepository $disciplinaRepository
     */
    public function __construct(
        TurmaRepository $repository,
        CurriculoRepository $curriculoRepository,
        DisciplinaRepository $disciplinaRepository,
        HorarioDisciplinaTurmaRepository $horarioDisciplinaTurmaRepository)
    {
        $this->repository           = $repository;
        $this->curriculoRepository  = $curriculoRepository;
        $this->disciplinaRepository = $disciplinaRepository;
        $this->horarioDisciplinaTurmaRepository = $horarioDisciplinaTurmaRepository;
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
     * @return Turma
     * @throws \Exception
     */
    public function store(array $data) : Turma
    {
        #Aplicação das regras de negócios
        $data['tipo_nivel_sistema_id'] = 1;
        //$this->tratamentoDoCurso($data);

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
     * @return Turma
     * @throws \Exception
     */
    public function update(array $data, int $id) : Turma
    {
        # Aplicação das regras de negócios
        $data['tipo_nivel_sistema_id'] = 1;
        //$this->tratamentoDoCurso($data, $id);

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
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        # Recuperando a turma
        $turma = $this->repository->find($id);

        # Verificando se a turma foi encontrada
        if(!$turma) {
            throw new \Exception('Turma não encontrada');
        }

        # Removendo a turma
        $this->repository->delete($turma->id);

        # Retorno
        return true;
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
     * Método usado para validar se o curso escolhido tem um currículo ativo
     * e se o for escolhido o mesmo curso (edição) permanece o currículo anterior
     * mesmo se o mesmo não estiver mais ativo.
     *
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
     * Método responsável de verificar a possibilidade de
     * mudança de currículo na turma.
     *
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

    /**[RF017-RN004]
     * Método responsável por vincular as disciplinas
     * do currículo do período em questão na turma.
     *
     * @param Turma $turma
     * @return bool
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
                # Verificando se a disciplina é do período da turma
                if($disciplina->pivot->periodo == $turma->periodo) {
                    # Recuperando o pivot
                    $pivotDisciplina = $disciplina->pivot;

                    # Recuperando o plano de ensino ativo
                    $planoEnsino = $disciplina->planosEnsinos->filter(function ($plano) use ($pivotDisciplina) {
                        return $plano->ativo && $plano->carga_horaria == $pivotDisciplina->carga_horaria_total;
                    });

                    # Validando o plano de ensino
                    $planoEnsino = count($planoEnsino) > 0 ? $planoEnsino->first()->id : null;

                    # Vinculando as disciplinas
                    $turma->disciplinas()->attach($disciplina, ['plano_ensino_id' => $planoEnsino]);
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

    /** Método responsável por atualizar as disciplinas
     *  da turma.
     *
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
     * Método responsável por incluir disciplinas (Manualmente)
     * na turma.
     *
     * @param array $data
     * @return bool|bool
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
        $eletiva      = (isset($data['eletiva'])) ? $data['eletiva'] : 0;

        # Recuperando a turma e a disciplina
        $objTurma      = $this->repository->find($idTurma);
        $objDisciplina = $this->disciplinaRepository->find($idDisciplina);

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && !$objDisciplina) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        # Recuperando a disciplina do vinculo com o currículo
        $curriculoDisciplina = $objTurma->curriculo->disciplinas->filter(function ($disciplina) use ($objDisciplina) {
            return $disciplina->id == $objDisciplina->id;
        });

        # Valor inicial para o plano de ensino
        $planoEnsino = null;

        # Verificando se foi filtrado alguma disciplina do currículo
        if(count($curriculoDisciplina) > 0) {
            # Transformando recuperando o objeto do array
            $curriculoDisciplina = $curriculoDisciplina->first();

            # Recuperando o pivot curriculo_disciplina
            $pivotCurriculoDisciplina = $curriculoDisciplina->pivot;

            # Recuperando o plano de ensino ativo para a disciplina em questão com a carga horária do currículo
            $planoEnsino = $curriculoDisciplina->planosEnsinos->filter(function ($plano) use ($pivotCurriculoDisciplina) {
                return $plano->ativo && $plano->carga_horaria == $pivotCurriculoDisciplina->carga_horaria_total;
            });

            # Validando o plano de ensino
            $planoEnsino = count($planoEnsino) > 0 ? $planoEnsino->first()->id : null;
        }

        #Incluindo e salvando a disciplina
        $objTurma->disciplinas()->attach($objDisciplina->id, ['plano_ensino_id' => $planoEnsino, 'eletiva' => $eletiva]);
        $objTurma->save();

        #Retorno
        return true;
    }

    /**
     * Método responsável por remover disciplina (manualmente)
     * na turma.
     *
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

        # Recuperando a turma da disciplina
        $turmDisciplina = $objTurma->disciplinas->filter(function ($disciplina) use($objDisciplina) {
            return $disciplina->id == $objDisciplina->id;
        });

        # Recuperando o pivot
        $turmaDisciplinaPivot = $turmDisciplina->first()->pivot;

        # Removendo os diários
        $turmaDisciplinaPivot->diarios->each(function ($item, $key) {
            # Removendo os diários
            $item->delete();

            # Não terá retorno
            return false;
        });

        #Incluindo e salvando a disciplina
        $objTurma->disciplinas()->detach($objDisciplina->id);
        $objTurma->save();

        #Retorno
        return true;
    }

    /**
     * Método responsável por incluir horário a turma.
     *
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function incluirHorario(array $data) : bool
    {
        # Aplicando as regras de negócios
        $this->tratamentoCampos($data);

        # Validando a requisição
        if( !(isset($data['disciplina_id']) && is_numeric($data['disciplina_id'])) ||
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Disciplina e Professor são campos obrigatórios!");
        }

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

        # Recuperando o currículoe a carga horária da disciplina em questão
        $curriculo    = $objTurma->curriculo;
        $cargaHoraria = $curriculo->disciplinas()->find($objDisciplina->id)->pivot->carga_horaria_total;

        #Incluindo e salvando a disciplina
        $disciplina = $objTurma->disciplinas()->find($objDisciplina->id);
        $pivot      = $disciplina->pivot;

        # Verificanado se foi passado o professor
        if(isset($data['professor_id'])) {
            # Query para busca de choque de horários
            $rowsHorarios = \DB::table('fac_horarios')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
                ->join('fac_curriculo_disciplina', function ($join) {
                    $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                        ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_turmas_disciplinas.disciplina_id');
                })
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->join('fac_dias', 'fac_dias.id', '=', 'fac_horarios.dia_id')
                ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                ->join('fac_professores', 'fac_professores.id', '=', 'fac_horarios.professor_id')
                ->join('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
                ->where('fac_dias.id', $data['dia_id'])
                ->where('fac_horas.id', $data['hora_id'])
                ->where('fac_professores.id', $data['professor_id'])
                ->select([
                    'fac_horarios.id',
                    'fac_horas.nome as hora',
                    'fac_dias.nome as dia',
                    'pessoas.nome',
                    'fac_disciplinas.nome as nomeDisciplina',
                    'fac_curriculo_disciplina.carga_horaria_total',
                    'fac_turmas.codigo as codigoTurma',
                    'fac_turmas_disciplinas.disciplina_id'
                ])->get();

            # Verificando algumas regras de validação
            if(count($rowsHorarios) > 0) {
                # Quebra de linha
                $quebraLinha = utf8_encode("\n");

                foreach ($rowsHorarios as $row) {
                    # Velidação  se as disciplinas forem diferentes
                    if($row->disciplina_id != $disciplina->id) {
                        $msg = "Professor: {$row->nome} {$quebraLinha} Turma: {$row->codigoTurma} {$quebraLinha} Disciplina: {$row->nomeDisciplina} {$quebraLinha} CH: {$row->carga_horaria_total}";
                        throw new \Exception("Foi detectado um choque de horário: \n {$msg}");
                    }

                    # Validação se as disciplinas forem iguais
                    if($row->disciplina_id == $disciplina->id && $row->carga_horaria_total != $cargaHoraria) {
                        $msg = "Professor: {$row->nome} {$quebraLinha} Turma: {$row->codigoTurma} {$quebraLinha} Disciplina: {$row->nomeDisciplina} {$quebraLinha} CH: {$row->carga_horaria_total}";
                        throw new \Exception("Foi detectado um choque de horário: \n {$msg}");
                    }
                }
            }
        }

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
        if(!(isset($data['idDia']) && is_numeric($data['idDia'])) ||
            !(isset($data['idHora']) && is_numeric($data['idHora'])) ||
            !(isset($data['idTurma']) && is_numeric($data['idTurma']))) {
            throw new \Exception("Parametros inválidos");
        }

        # Recuperando os parametros da requisição
        $idTurma = $data['idTurma'];
        $idDia   = $data['idDia'];
        $idHora  = $data['idHora'];
        $idTurno  = $data['idTurno'];

        # Recuperando a turma e a disciplina
        $objTurma   = $this->repository->find($idTurma);
        $resultId   = \DB::table('fac_horarios')
            ->select(['fac_turmas_disciplinas.disciplina_id', 'fac_horarios.id'])
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->join('fac_turnos', 'fac_turnos.id', '=', 'fac_turmas.turno_id')
            ->where('fac_turmas.id', $idTurma)
            ->where('fac_horarios.dia_id', $idDia)
            ->where('fac_horarios.hora_id', $idHora)
            ->where('fac_turnos.id', $idTurno)
            ->get();
        var_dump($resultId);exit;

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && count($resultId) == 0) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        # Recuperando os alunos cadastrados para esse horário
        $alunos  = \DB::table('fac_alunos_semestres_horarios')
            ->join('fac_horarios', 'fac_horarios.id', '=', 'fac_alunos_semestres_horarios.horario_id')
            ->whereIn('fac_alunos_semestres_horarios.horario_id', [$resultId[0]->id])->get();

        # Verificando se tem alunos cadastrados para esse horário
        if(count($alunos) > 0) {
            throw new \Exception("Existem alunos nesse horário.");
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
     * @param $idTurma
     * @param $idHora
     * @param $idDia
     * @return mixed
     * @throws \Exception
     */
    public function editHorario($idTurma, $idHora, $idDia)
    {
        # Recuperando os horários
        $horarios   = \DB::table('fac_horarios')
            ->select(['fac_horarios.id'])
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->where('fac_turmas.id', $idTurma)
            ->where('fac_horarios.dia_id', $idDia)
            ->where('fac_horarios.hora_id', $idHora)
            ->get();

        # Verificando se foi retornado os horários
        if(!count($horarios) > 0) {
            throw new \Exception('Nenhum horário foi encontrado');
        }

        # Recuperando o objeto de horário
        $horario = $this->horarioDisciplinaTurmaRepository->find($horarios[0]->id);

        # Verificando se foi retornado o horário
        if(!$horario) {
            throw new \Exception('Horário não encontrado');
        }

        # Retorno
        return $horario;
    }

    /**
     * @param array $data
     * @param int $id
     * @return HorarioDisciplinaTurma
     * @throws \Exception
     */
    public function updateHorario(array $data, int $id) : HorarioDisciplinaTurma
    {
        # Aplicação das regras de negócios
        $this->tratamentoCampos($data);

        # Recuperando o objeto de horário
        $horario = $this->horarioDisciplinaTurmaRepository->find($id);

        # Recuperando o id da turma
        $queryTurma = \DB::table('fac_turmas_disciplinas')
            ->where('id', $horario->turma_disciplina_id)
            ->select(['turma_id as id', 'disciplina_id'])
            ->get()[0];

        # Recuperando a turma, disciplina
        $turma = $this->repository->find($queryTurma->id);
        $disciplina = $turma->disciplinas()->find($queryTurma->disciplina_id);

        # Recuperando o currículoe a carga horária da disciplina em questão
        $curriculo    = $turma->curriculo;
        $cargaHoraria = $curriculo->disciplinas()->find($disciplina->id)->pivot->carga_horaria_total;

        # Validando se o professor foi informado
        if((isset($data['professor_id']) && is_numeric($data['professor_id']))) {
            # Query para busca de choque de horários
            $rowsHorarios = \DB::table('fac_horarios')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
                ->join('fac_curriculo_disciplina', function ($join) {
                    $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                        ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_turmas_disciplinas.disciplina_id');
                })
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->join('fac_dias', 'fac_dias.id', '=', 'fac_horarios.dia_id')
                ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                ->join('fac_professores', 'fac_professores.id', '=', 'fac_horarios.professor_id')
                ->join('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
                ->where('fac_dias.id', $horario->dia->id)
                ->where('fac_horas.id', $horario->hora->id)
                ->where('fac_professores.id', $horario->professor->id)
                ->where('fac_turmas.id', '!=', $turma->id)
                ->select([
                    'fac_horarios.id',
                    'fac_horas.nome as hora',
                    'fac_dias.nome as dia',
                    'pessoas.nome',
                    'fac_disciplinas.nome as nomeDisciplina',
                    'fac_curriculo_disciplina.carga_horaria_total',
                    'fac_turmas.codigo as codigoTurma',
                    'fac_turmas_disciplinas.disciplina_id'
                ])->get();

            # Verificando algumas regras de validação
            if(count($rowsHorarios) > 0) {
                # Quebra de linha
                $quebraLinha = utf8_encode("\n");

                foreach ($rowsHorarios as $row) {
                    # Velidação  se as disciplinas forem diferentes
                    if($row->disciplina_id != $disciplina->id) {
                        $msg = "Professor: {$row->nome} {$quebraLinha} Turma: {$row->codigoTurma} {$quebraLinha} Disciplina: {$row->nomeDisciplina} {$quebraLinha} CH: {$row->carga_horaria_total}";
                        throw new \Exception("Foi detectado um choque de horário: \n {$msg}");
                    }

                    # Validação se as disciplinas forem iguais
                    if($row->disciplina_id == $disciplina->id && $row->carga_horaria_total != $cargaHoraria) {
                        $msg = "Professor: {$row->nome} {$quebraLinha} Turma: {$row->codigoTurma} {$quebraLinha} Disciplina: {$row->nomeDisciplina} {$quebraLinha} CH: {$row->carga_horaria_total}";
                        throw new \Exception("Foi detectado um choque de horário: \n {$msg}");
                    }
                }
            }
        }

        # Atualizando no banco de dados
        $horario = $this->horarioDisciplinaTurmaRepository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if (!$horario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Retorno
        return $horario;
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

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function eJuncao(array $data)
    {
        # Validando a requisição
        if( !(isset($data['disciplina_id']) && is_numeric($data['disciplina_id'])) ||
            !(isset($data['idTurma']) && is_numeric($data['idTurma'])) ||
            !(isset($data['professor_id']) && is_numeric($data['professor_id']))) {
            throw new \Exception();
        }

        # Recuperando a turma e a disciplina
        $objTurma      = $this->repository->find($data['idTurma']);
        $objDisciplina = $this->disciplinaRepository->find($data['disciplina_id']);

        # Verificando se foi encontrada uma turma e disciplina
        if(!$objTurma && !$objDisciplina) {
            throw new \Exception("Turma ou disciplina informada não encontrada");
        }

        # Recuperando o currículoe a carga horária da disciplina em questão
        $curriculo    = $objTurma->curriculo;
        $cargaHoraria = $curriculo->disciplinas()->find($objDisciplina->id)->pivot->carga_horaria_total;

        # Query para busca de choque de horários
        $query = \DB::table('fac_horarios')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_turmas_disciplinas.disciplina_id');
            })
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
            ->join('fac_dias', 'fac_dias.id', '=', 'fac_horarios.dia_id')
            ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
            ->join('fac_professores', 'fac_professores.id', '=', 'fac_horarios.professor_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
            ->where('fac_dias.id', $data['dia_id'])
            ->where('fac_horas.id', $data['hora_id'])
            ->where('fac_professores.id', $data['professor_id'])
            ->select([
                'fac_horarios.id',
                'fac_horas.nome as hora',
                'fac_dias.nome as dia',
                'pessoas.nome',
                'fac_disciplinas.nome as nomeDisciplina',
                'fac_curriculo_disciplina.carga_horaria_total',
                'fac_turmas.codigo as codigoTurma',
                'fac_turmas_disciplinas.disciplina_id'
            ]);

        # Se for uma requisição de update
        if(isset($data['edit']) && $data['edit']) {
            $query->where('fac_turmas.id', '!=', $objTurma->id);
        }

        # Recuperando os registros
        $rowsHorarios = $query->get();

        # Verificando algumas regras de validação
        if(count($rowsHorarios) > 0) {
            foreach ($rowsHorarios as $row) {
                # Velidação  se as disciplinas forem diferentes
                if($row->disciplina_id != $objDisciplina->id) {
                    throw new \Exception();
                }

                # Validação se as disciplinas tiverem cargas horárias diferentes
                if($row->disciplina_id == $objDisciplina->id && $row->carga_horaria_total != $cargaHoraria) {
                    throw new \Exception();
                }


            }
        } else {
            throw new \Exception();
        }

        # retorno caso seja satisfeita a condição de junção
        return true;
    }
}