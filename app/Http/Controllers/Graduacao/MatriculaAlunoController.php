<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoService;
use Seracademico\Validators\Graduacao\AlunoValidator;
use Yajra\Datatables\Datatables;
use Seracademico\Facades\ParametroMatriculaFacade;

class MatriculaAlunoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $alunoService;

    /**
     * @var array
     */
    private $loadFields = [
    ];

    /**
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service)
    {
        $this->alunoService = $service;
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
    public function gridAluno()
    {
        try {
            # recuperando as configurações
            $semestres = [
                ParametroMatriculaFacade::getSemestreVigente(),
                ParametroMatriculaFacade::getSemestreSelMatricula()
            ];

            #Criando a consulta
            $alunos = \DB::table('fac_alunos')
                ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
                ->join('fac_turnos', 'fac_turnos.id', '=', 'fac_alunos.turno_id')
                ->join('fac_alunos_semestres', function ($join) {
                    $join->on(
                        'fac_alunos_semestres.id', '=',
                        \DB::raw('(SELECT semestre_secundario.id FROM fac_alunos_semestres as semestre_secundario 
                    where semestre_secundario.aluno_id = fac_alunos.id ORDER BY semestre_secundario.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->join('fac_alunos_cursos', function ($join) {
                    $join->on(
                        'fac_alunos_cursos.id', '=',
                        \DB::raw('(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                    where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_cursos.curriculo_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->join('fac_alunos_situacoes', function ($join) {
                    $join->on(
                        'fac_alunos_situacoes.id', '=',
                        \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria 
                    where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
                ->where(function ($query) use ($semestres) {
                    $query->where(function ($query) use ($semestres) {
                            $query->where('fac_semestres.id', $semestres[1]->id)->whereNotNull('fac_alunos_semestres.periodo');
                        })
                        ->orWhere(function ($query) use ($semestres) {
                            $query->whereNull('fac_alunos_semestres.periodo')->where('fac_semestres.id', $semestres[0]->id);
                        });
                })
                ->groupBy('fac_alunos.id')
                ->select([
                    'fac_alunos.id',
                    'pessoas.nome',
                    'pessoas.cpf',
                    'fac_alunos.matricula',
                    'pessoas.celular',
                    'fac_alunos_semestres.id as IDTESTE',
                    'fac_semestres.id as idSemestre',
                    'fac_situacao.nome as nomeSituacao',
                    'fac_curriculos.codigo as codCurriculo',
                    'fac_cursos.codigo as codCurso',
                    'fac_turnos.nome as nomeTurno',
                    'fac_alunos_semestres.periodo'
                ]);

            #Editando a grid
            return Datatables::of($alunos)->make(true);
        } catch (\Throwable $e) {
            abort(500);
        }
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
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
//           ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
//                $query->from('fac_alunos_semestres_disciplinas')
//                    ->select('fac_alunos_semestres_disciplinas.disciplina_id')
//                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas.aluno_semestre_id')
//                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
//                    ->where('fac_alunos.id', $idAluno);
//            })
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_alunos_notas.turma_disciplina_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_disciplinas_dispensadas')
                    ->select('fac_alunos_semestres_disciplinas_dispensadas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->orderBy('fac_curriculo_disciplina.periodo')
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
    public function getTurmas(Request $request)
    {
        try {
            # Variável que armazenará o array de retorno
            $dados = [];

            # Recuperando o semestre vigente
            $semestreVigente = ParametroMatriculaFacade::getSemestreVigente();

            # Fazendo a consulta pincipal e recuperando os registros
            $rows  = \DB::table('fac_disciplinas')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_turmas.semestre_id')
                ->whereIn('fac_disciplinas.id', $request->get('dados'))
                ->where('fac_semestres.id', $semestreVigente->id)
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
                    ->where('fac_semestres.id', $semestreVigente->id)
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
     * @return mixed
     */
    public function gridHorario($idAluno)
    {
        # recuperando as configurações
        $semestres = [
            ParametroMatriculaFacade::getSemestreVigente(),
            ParametroMatriculaFacade::getSemestreSelMatricula()
        ];

        #Criando a consulta
        $rows = \DB::table('fac_horarios')
            ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
            ->where('fac_alunos.id', $idAluno)
            ->where('fac_semestres.id', $semestres[0]->id)
            ->groupBy('fac_horas.id')
            ->orderBy('fac_horas.id')
            ->select([
                'fac_horarios.id',
                'fac_horas.id as hora',
                'fac_horas.nome as codigoHora',
                'fac_alunos.id as idAluno',
                'fac_semestres.id as idSemestre'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('domingo', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 1)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('segunda', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 2)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('terca', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 3)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('quarta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 4)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('quinta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 5)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('sexta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 6)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('sabado', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                    ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_horarios.dia_id', 7)->get();

                return $result[0]->codigo ?? "";
            })->make(true);
    }

    /**
     * @param Request $request
     */
    public function adicionarHorarioAluno(Request $request)
    {
        try {
        # recuperando as configurações
        $semestres = [
            ParametroMatriculaFacade::getSemestreVigente(),
            ParametroMatriculaFacade::getSemestreSelMatricula(),
            ParametroMatriculaFacade::getPreRequisitoSelMatricula()
        ];

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
            ->where('fac_semestres.id', $semestres[0]->id)
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
            ->join("fac_turmas", "fac_turmas.id", "=", "fac_turmas_disciplinas.turma_id")
            ->where('fac_turmas_disciplinas.id', $dados['idTurmaDisciplina'])
            ->select('fac_horarios.id', 'fac_turmas_disciplinas.disciplina_id', 'fac_turmas.id as turma_id')
            ->get();

        # Recuperando o aluno e o semestre
        $aluno     = $this->alunoService->find($dados['idAluno']);
        $semestre  = $aluno->semestres()->find($semestres[0]->id);

        # Verificando se o semestre já foi cadastrado
        if(!$semestre) {
            # Cadastrando o aluno no semestre vigente
            $aluno->semestres()->attach([$semestres[0]->id]);

            # Recuperando o semestre cadastrado
            $semestre = $aluno->semestres()->find($semestres[0]->id);

            # Setando a situação
            $semestre->pivot->situacoes()->attach([1]);
        }

        # Verificando no parãmetro do sistema se
        # é para bloquear por pré-requisitos
        if($semestres[2] === "Sim") {
            # Fazendo as validações de pré-requisito
            foreach ($rows as $row) {
                # Fazendo a consulta no banco de dados
                $query = \DB::table('fac_curriculos')
                    ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
                    ->where('fac_curriculo_disciplina.disciplina_id', $row->disciplina_id)
                    ->where('fac_turmas.id', $row->turma_id)
                    ->select([
                        'fac_curriculo_disciplina.pre_requisito_1_id',
                        'fac_curriculo_disciplina.pre_requisito_2_id',
                        'fac_curriculo_disciplina.pre_requisito_3_id',
                        'fac_curriculo_disciplina.pre_requisito_4_id',
                        'fac_curriculo_disciplina.pre_requisito_5_id'
                    ])->get();

                # Verificando se foi retornado o registro
                if(count($query) == 1) {
                    # Recuperando o objeto do currículo
                    $objCurriculo = $query[0];

                    # Array de pré-requisitos
                    $arrayPreReq = array(
                        $objCurriculo->pre_requisito_1_id,
                        $objCurriculo->pre_requisito_2_id,
                        $objCurriculo->pre_requisito_3_id,
                        $objCurriculo->pre_requisito_4_id,
                        $objCurriculo->pre_requisito_5_id
                    );

                    # Filtrando o array de pré-reuisitos
                    $arrayPreReq = \array_filter($arrayPreReq, function ($value) {
                        return $value =! null && $value != '';
                    });

                    # Query de validação
                    $queryPreReq = \DB::table('fac_alunos_notas')
                        ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_alunos_notas.turma_disciplina_id')
                        ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                        ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                        ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                        ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                        ->where('fac_alunos.id', $aluno->id)
                        ->whereIn('fac_situacao_nota.id', [1,6,7])
                        ->whereIn('fac_disciplinas.id', $arrayPreReq)
                        ->select(['fac_alunos_notas.id'])->get();

                    # Verificando se existe pré-requisitos
                    if(count($arrayPreReq) > 0 ) {
                        # Verificanso se o aluno pagou todos
                        if(count($arrayPreReq) !== count($queryPreReq)) {
                            throw new \Exception('Está disciplina possui pré-requisitos que o aluno não concluio!');
                        }
                    }
                }
            }
        }

        # cadastrando os horários e disciplinas
        $semestre->pivot->horarios()->attach(array_unique(array_column($rows, 'id')));
        $semestre->pivot->disciplinas()->attach(array_unique(array_column($rows, 'disciplina_id')));

        #Retorno para a view
        return \Illuminate\Support\Facades\Response::json(['success' => true]);
    } catch (\Throwable $e) {
        #Retorno para a view
        return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
    }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function finalizarMatricula(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados   = $request->all();

            # Verificando a requisição
            if(!isset($dados['idAluno'])) {
                throw new \Exception('Parêmetro inválido!');
            }

            # Recuperando o aluno
            $aluno = $this->alunoService->find($dados['idAluno']);

            # Verificando se aluno existe
            if(!$aluno) {
                throw new \Exception('Aluno não encontrado');
            }

            # recuperando as configurações
            $semestres = [
                ParametroMatriculaFacade::getSemestreVigente(),
                ParametroMatriculaFacade::getSemestreSelMatricula()
            ];

            # Recuperando o semestre
            $semestre = $aluno->semestres()->find($semestres[0]->id);

            # verificando se o aluno está matriculado no semestre atual
            if(!$semestre) {
                throw new \Exception('Aluno não tem horário.');
            }

            #data atual
            $now = new \DateTime('now');

            # Recuperando o ultimo currículo do aluno
            $curriculo = $aluno->curriculos()->get()->last();

            # Recuperando os ids do pivot TurmaDisciplina correspondentes.
            $rows = \DB::table('fac_turmas_disciplinas')
                ->select(['fac_turmas_disciplinas.id'])
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->where('fac_alunos.id', $dados['idAluno'])
                ->where('fac_semestres.id', $semestre->id)
                ->groupBy('fac_turmas_disciplinas.id')->get();

            # recuperando o curriculo
            $curriculo = $aluno->curriculos()->get()->last();
              
            #cadastradando a situação
            $semestre->pivot->situacoes()->attach(13, ['data' => $now->format('YmdHis'), 'curriculo_origem_id' => $curriculo->id]);

            #Cadastrando o período
            $semestre->pivot->periodo = $dados['periodo'];
            $semestre->pivot->save();

            # Cadastrando as notas do aluno
            foreach ($rows as $row) {
                # Criando e recuperando a nota do aluno
                $alunoNota = $semestre->pivot->alunosNotas()->create([
                    'turma_disciplina_id' => $row->id,
                    'situacao_id' => 10,
                    'curriculo_id' => $curriculo->id
                ]);

                # Criando a frequência
                $alunoNota->frequencia()->create([]);
            }

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Matrícula realizada com sucesso!']);
        } catch (\Throwable $e) {
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

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function validarPreRequisito(Request $request)
    {
        try {
            # recuperando as configurações
            $semestres = [
                ParametroMatriculaFacade::getSemestreVigente(),
                ParametroMatriculaFacade::getSemestreSelMatricula(),
                ParametroMatriculaFacade::getPreRequisitoSelMatricula()
            ];

            # Recuperando os dados da requisição
            $dados = $request->all();

            # Recuperando os ids dos horários
            $rows = \DB::table("fac_horarios")
                ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.id", "=", "fac_horarios.turma_disciplina_id")
                ->join("fac_turmas", "fac_turmas.id", "=", "fac_turmas_disciplinas.turma_id")
                ->where('fac_turmas_disciplinas.id', $dados['idTurmaDisciplina'])
                ->select('fac_horarios.id', 'fac_turmas_disciplinas.disciplina_id', 'fac_turmas.id as turma_id')
                ->get();

            # Recuperando o aluno e o semestre
            $aluno = $this->alunoService->find($dados['idAluno']);


            # Verificando no parãmetro do sistema se
            # é para bloquear por pré-requisitos
            if($semestres[2] === "Não") {
                # Fazendo as validações de pré-requisito
                foreach ($rows as $row) {
                    # Fazendo a consulta no banco de dados
                    $query = \DB::table('fac_curriculos')
                        ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                        ->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
                        ->where('fac_curriculo_disciplina.disciplina_id', $row->disciplina_id)
                        ->where('fac_turmas.id', $row->turma_id)
                        ->select([
                            'fac_curriculo_disciplina.pre_requisito_1_id',
                            'fac_curriculo_disciplina.pre_requisito_2_id',
                            'fac_curriculo_disciplina.pre_requisito_3_id',
                            'fac_curriculo_disciplina.pre_requisito_4_id',
                            'fac_curriculo_disciplina.pre_requisito_5_id'
                        ])->get();

                    # Verificando se foi retornado o registro
                    if(count($query) == 1) {
                        # Recuperando o objeto do currículo
                        $objCurriculo = $query[0];

                        # Array de pré-requisitos
                        $arrayPreReq = array(
                            $objCurriculo->pre_requisito_1_id,
                            $objCurriculo->pre_requisito_2_id,
                            $objCurriculo->pre_requisito_3_id,
                            $objCurriculo->pre_requisito_4_id,
                            $objCurriculo->pre_requisito_5_id
                        );

                        # Filtrando o array de pré-reuisitos
                        $arrayPreReq = \array_filter($arrayPreReq, function ($value) {
                            return $value =! null && $value != '';
                        });

                        # Query de validação
                        $queryPreReq = \DB::table('fac_alunos_notas')
                            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_alunos_notas.turma_disciplina_id')
                            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                            ->where('fac_alunos.id', $aluno->id)
                            ->whereIn('fac_situacao_nota.id', [1,6,7]) // Situações de cumprimento da disciplina
                            ->whereIn('fac_disciplinas.id', $arrayPreReq)
                            ->select(['fac_alunos_notas.id'])->get();

                        # Verificando se existe pré-requisitos
                        if(count($arrayPreReq) > 0 ) {
                            # Verificanso se o aluno pagou todos
                            if(count($arrayPreReq) !== count($queryPreReq)) {
                                break;
                            }
                        }
                    }
                }
            } else {
                throw new \Exception("Bloqueio Ativado!");
            }

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}