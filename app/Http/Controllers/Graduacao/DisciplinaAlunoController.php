<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoNotaService;
use Seracademico\Services\Graduacao\AlunoService;
use Seracademico\Uteis\ConsultationsBuilders\Aluno\BuildersExtraCurricular;
use Yajra\Datatables\Datatables;

class DisciplinaAlunoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $alunoService;

    /**
     * @var AlunoNotaService
     */
    private $alunoNotaService;

    /**
     * @var array
     */
    private $loadFields = [
    ];

    /**
     * DisciplinaAlunoController constructor.
     * @param AlunoService $service
     * @param AlunoNotaService $alunoNotaService
     */
    public function __construct(AlunoService $service, AlunoNotaService $alunoNotaService)
    {
        $this->alunoService     = $service;
        $this->alunoNotaService = $alunoNotaService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('matricula.index');
    }
    
    /**
     * @return mixed
     */
    public function gridDisciplina($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                    where curso_atual.curriculo_id = fac_curriculos.id and curso_atual.aluno_id = ' . $idAluno . '  ORDER BY fac_alunos_cursos.id DESC LIMIT 1)')
                );
            })
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_cursos.aluno_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_eletivas')
                    ->select('fac_alunos_semestres_eletivas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_eletivas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            // Alterar depois de regularizar a situação das dispensadas em alunos_notas
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_disciplinas_dispensadas')
                    ->select('fac_alunos_semestres_disciplinas_dispensadas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_equivalencias')
                    ->select('fac_alunos_semestres_equivalencias.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_equivalencias.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->union(BuildersExtraCurricular::getExtraCurricularMatricular($idAluno))
            ->union(BuildersExtraCurricular::getEletivasMatricula($idAluno))
            ->union(BuildersExtraCurricular::getEquivalenciaMatricular($idAluno))
            ->orderBy('periodo')
            ->select([
                    'fac_disciplinas.id',
                    'fac_disciplinas.nome',
                    'fac_disciplinas.codigo',
                    'fac_disciplinas.carga_horaria',
                    'fac_disciplinas.qtd_falta',
                    'fac_curriculo_disciplina.periodo',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                    'pessoas.nome as nomeAluno',
                    'fac_cursos.nome as nomeCurso'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTurmas(Request $request, $idSemestre)
    {
        try {
            # Variável que armazenará o array de retorno
            $dados = [];

            # Fazendo a consulta pincipal e recuperando os registros
            $rows  = \DB::table('fac_disciplinas')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_turmas.semestre_id')
                ->whereIn('fac_disciplinas.id', $request->get('dados'))
                ->where('fac_semestres.id', $idSemestre)
                ->groupBy('fac_disciplinas.id')
                ->select([
                    'fac_disciplinas.id',
                    'fac_disciplinas.codigo as codigoDisciplina',
                    'fac_disciplinas.nome as nomeDisciplina'
                ])->get();

            # Tratanto os dados de retorno
            $count = 0;
            foreach ($rows as $row) {
                # variárel que armazenará o array de turmas
                $arrayTurmas = [];

                # Carregando a disciplina
                $dados[$count]['nomeDisciplina']   = $row->nomeDisciplina;
                $dados[$count]['codigoDisciplina'] = $row->codigoDisciplina;
                $dados[$count]['idDisciplina']     = $row->id;

                // Recuperando as turmas
                $rowsTurma = \DB::table('fac_turmas')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_turmas.semestre_id')
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                    ->where('fac_disciplinas.id', $row->id)
                    ->where('fac_semestres.id', $idSemestre)
                    ->select([
                        'fac_turmas_disciplinas.id as idTurmaDisciplina',
                        'fac_turmas.codigo as codigoTurma',
                        'fac_turmas.descricao as nomeTurma',
                    ])->get();

                // Percorrendo e criando o array de turmas
                $countTurmas = 0;
                foreach ($rowsTurma as $turma) {
                    $arrayTurmas[$countTurmas]['idTurmaDisciplina'] = $turma->idTurmaDisciplina;
                    $arrayTurmas[$countTurmas]['codigoTurma']       = $turma->codigoTurma;
                    $arrayTurmas[$countTurmas]['nomeTurma']         = $turma->nomeTurma;
                    $arrayTurmas[$countTurmas]['horarios']          = \DB::table('fac_horarios')
                        ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                        ->join('fac_dias', 'fac_dias.id', '=', 'fac_horarios.dia_id')
                        ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                        ->where('fac_turmas_disciplinas.id', $turma->idTurmaDisciplina)
                        ->select([
                            'fac_dias.nome as nomeDia',
                            'fac_horas.hora_inicial',
                            'fac_horas.hora_final',
                            'fac_horas.nome as codigoHora'
                        ])->get();

                    # Contador
                    $countTurmas++;
                }

                # Atribuindo o array de turmas ao array principal
                $dados[$count]['turmas'] = $arrayTurmas;

                // Contador
                $count++;
            }

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'dados' => $dados]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
    
    /**
     * @param Request $request
     */
    public function adicionarHorarioAluno(Request $request, $idSemestre)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # recuperando as horas e os dias dos alunos
            $horariosAluno = \DB::table("fac_horarios")
                ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                ->join('fac_dias', 'fac_dias.id', '=', 'fac_horarios.dia_id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->where('fac_alunos.id', $dados['idAluno'])
                ->where('fac_semestres.id', $idSemestre)
                ->whereExists(function ($query) use($dados) {
                    $query->from('fac_horarios as horarios')
                        ->join('fac_horas as horas', 'horas.id', '=', 'horarios.hora_id')
                        ->join('fac_dias as dias', 'dias.id', '=', 'horarios.dia_id')
                        ->join("fac_turmas_disciplinas as td", "td.id", "=", "horarios.turma_disciplina_id")
                        ->join("fac_disciplinas as disciplina", "disciplina.id", "=", "td.disciplina_id")
                        ->join('fac_turmas as t', 't.id', '=', 'td.turma_id')
                        ->where('td.id', $dados['idTurmaDisciplina'])
                        ->whereRaw('fac_horas.id = horas.id')
                        ->whereRaw('fac_dias.id = dias.id');
                })->lists('fac_horarios.id');
            
            # Fazendo a validação
            if(count($horariosAluno) > 0) {
                throw new \Exception("Esse horário já foi cadastrado");
            }

            # Recuperando os ids dos horários
            $rows = \DB::table("fac_horarios")
                ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.id", "=", "fac_horarios.turma_disciplina_id")
                ->where('fac_turmas_disciplinas.id', $dados['idTurmaDisciplina'])
                ->select('fac_horarios.id', 'fac_turmas_disciplinas.disciplina_id')
                ->get();

            # Recuperando o aluno e o semestre
            $aluno     = $this->alunoService->find($dados['idAluno']);
            $semestre  = $aluno->semestres()->find($idSemestre);

            # Verificando se o semestre já foi cadastrado
            if(!$semestre) {
                # Cadastrando o aluno no semestre vigente
                $aluno->semestres()->attach([$idSemestre]);

                # Recuperando o semestre cadastrado
                $semestre = $aluno->semestres()->find($idSemestre);

                # Setando a situação
                $semestre->pivot->situacoes()->attach([1]);
            }
           
            # cadastrando os horários e disciplinas
            $semestre->pivot->horarios()->attach(array_unique(array_column($rows, 'id')));
            //$semestre->pivot->disciplinas()->attach(array_unique(array_column($rows, 'disciplina_id')));

            # Recuperando os ids do pivot TurmaDisciplina correspondentes.
            $turmasDisciplinas = \DB::table('fac_turmas_disciplinas')
                ->select(['fac_turmas_disciplinas.turma_id', 'fac_turmas_disciplinas.disciplina_id', 'fac_curriculos.id as curriculo_id'])
                ->join("fac_turmas", 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->where('fac_alunos.id', $aluno->id)
                ->where('fac_semestres.id', $semestre->id)
                ->whereIn('fac_horarios.id', array_column($rows, 'id'))
                ->groupBy('fac_turmas_disciplinas.id')->get();

            # Cadastrando as notas do aluno
            foreach ($turmasDisciplinas as $row) {
                # Criando e recuperando a nota do aluno
                $alunoNota = $semestre->pivot->alunosNotas()->create([
                    'turma_id' => $row->turma_id,
                    'disciplina_id' => $row->disciplina_id,
                    'situacao_id' => 10,
                    'curriculo_id' => $row->curriculo_id
                ]);

                # Criando a frequência
                $alunoNota->frequencia()->create([]);
            }

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) { dd($e->getMessage());
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     */
     public function getDisciplinas(Request $request)
     {
        try {
            # Recuperando os dados da rquisição
            $idAluno    = $request->get('idAluno');
            $idSemestre = $request->get('idSemestre');

            # Criando a query
            $query = \DB::table('fac_disciplinas')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->where('fac_alunos.id', $idAluno)
                ->where('fac_semestres.id', $idSemestre)
                ->groupBy('fac_disciplinas.id')
                ->select([
                    'fac_disciplinas.id',
                    'fac_disciplinas.nome'
                ])->get();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $query]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
     }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removerHorario(Request $request)
    {
        try {
            # Recuperando os dados da rquisição
            $idAluno      = $request->get('idAluno');
            $idSemestre   = $request->get('idSemestre');
            $idDisciplina = $request->get('idDisciplina');

            # Criando a query
            $horarios = \DB::table('fac_horarios')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->where('fac_alunos.id', $idAluno)
                ->where('fac_semestres.id', $idSemestre)
                ->where('fac_disciplinas.id', $idDisciplina)
                ->groupBy('fac_horarios.id')
                ->lists('fac_horarios.id');

            # Validando os horários
            if (!count($horarios) > 0) {
                throw new \Exception('Horários não encontrados');
            }

            # Recuperando o aluno
            $aluno         = $this->alunoService->find($idAluno);
            $semestre      = $aluno->semestres()->find($idSemestre);
            $alunoSemestre = $semestre->pivot;

            # removendo os horários
            $alunoSemestre->horarios()->detach($horarios);
            $alunoSemestre->disciplinas()->detach($idDisciplina);

            # Removendo as notas e frequências
            $this->alunoNotaService->deleteByAlunoAndDisciplina($idAluno, $idSemestre, $idDisciplina);
            
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

}