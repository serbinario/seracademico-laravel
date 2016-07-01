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
        # recuperando as configurações
        $semestres = $this->getParametrosMatricula();

        # verificando se os parâmetros foram carregados
        if(!is_array($semestres) && count($semestres) !== 2) {
            abort(500);
        }

        #Criando a consulta
        $alunos = \DB::table('fac_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->join('fac_alunos_semestres', function ($join) {
                $join->on(
                    'fac_alunos_semestres.id', '=',
                    \DB::raw('(SELECT semestre_secundario.id FROM fac_alunos_semestres as semestre_secundario 
                    where semestre_secundario.aluno_id = fac_alunos.id ORDER BY semestre_secundario.id DESC LIMIT 1)')
                );
            })
//            ->join('fac_alunos_situacoes', function ($join) {
//                $join->on(
//                    'fac_alunos_situacoes.id', '=',
//                    \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria
//                    where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
//                );
//            })
//            ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->where(function ($query) use ($semestres) {
                $query->where('fac_semestres.id', $semestres[1]->id)
                ->orWhere('fac_alunos_semestres.periodo', null)->where('fac_semestres.id', $semestres[0]->id);
            })
            ->groupBy('fac_alunos.id')
            ->select([
                'fac_alunos.id',
                'pessoas.nome',
                'pessoas.cpf',
                'fac_alunos.matricula',
                'pessoas.celular',
                'fac_alunos_semestres.id as IDTESTE'
            ]);

        #Editando a grid
        return Datatables::of($alunos)->make(true);
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
            ->join(\DB::raw('(SELECT fac_alunos_cursos.* FROM fac_alunos_cursos ORDER BY fac_alunos_cursos.id DESC LIMIT 1)fac_alunos_cursos'), function ($join) {
                $join->on('fac_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id');
            })
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_disciplinas')
                    ->select('fac_alunos_semestres_disciplinas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas.aluno_semestre_id')
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

            # Fazendo a consulta pincipal e recuperando os registros
            $rows  = \DB::table('fac_disciplinas')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                ->whereIn('fac_disciplinas.id', $request->get('dados'))
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
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                    ->where('fac_disciplinas.id', $row->id)
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
        #Criando a consulta
        $rows = \DB::table('fac_horarios')
            ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
            ->where('fac_alunos.id', $idAluno)
            ->groupBy('fac_horas.id')
            ->orderBy('fac_horas.id')
            ->select([
                'fac_horarios.id',
                'fac_horas.id as hora',
                'fac_horas.nome as codigoHora',
                'fac_alunos.id as idAluno'
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
            # Recuperando os dados da requisição
            $dados   = $request->all();

            # Verificano se o horário já foi cadastrado
            $rowsVal = \DB::table("fac_horarios")
                ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.id", "=", "fac_horarios.turma_disciplina_id")
                ->join("fac_disciplinas", "fac_disciplinas.id", "=", "fac_turmas_disciplinas.disciplina_id")
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->where('fac_disciplinas.id', $dados['idDisciplina'])
                ->where('fac_alunos.id', $dados['idAluno'])
                ->select('fac_horarios.id')
                ->lists('fac_horarios.id');

            # Fazendo a validação
            if(count($rowsVal) > 0) {
                throw new \Exception("Esse horário já foi cadastrado");
            }

            # Recuperando os ids dos horários
            $rows = \DB::table("fac_horarios")
                ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.id", "=", "fac_horarios.turma_disciplina_id")
                ->where('fac_turmas_disciplinas.id', $dados['idTurmaDisciplina'])
                ->select('fac_horarios.id', 'fac_turmas_disciplinas.disciplina_id')
                ->get();

            # Recuperando o aluno
            $aluno = $this->alunoService->find($dados['idAluno']);

            # Recuperando o semestre vigete
            $semestres = $this->getParametrosMatricula();

            # Recuperando o semestre
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

            # Recuperando o semestre vigete
            $semestres = $this->getParametrosMatricula();

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
            $semestre->pivot->situacoes()->attach(2, ['data' => $now->format('YmdHis'), 'curriculo_origem_id' => $curriculo->id]);

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
     * @return mixed
     */
    private function getParametrosMatricula()
    {
        try {
            # Recuperando o item de parâmetro do semestre vigente
            $queryParameter = \DB::table('fac_parametros')
                ->join('fac_parametros_itens', 'fac_parametros_itens.parametro_id', '=', 'fac_parametros.id')
                ->select(['fac_parametros_itens.valor', 'fac_parametros_itens.nome'])
                ->where('fac_parametros_itens.id', 2)
                ->orWhere('fac_parametros_itens.id', 3)
                ->get();

            # Validando o parametro
            if(count($queryParameter) !== 2) {
                throw new \Exception('Parâmetro do semestre vigente não configurado');
            }

            # Recuperando o semestre
            $querySemestre = \DB::table('fac_semestres')
                ->select(['fac_semestres.id', 'fac_semestres.nome'])
                ->where('fac_semestres.nome', $queryParameter[0]->valor)
                ->orWhere('fac_semestres.nome', $queryParameter[1]->valor)
                ->where('fac_semestres.ativo', 1)
                ->get();

            # Validando o parametro
            if(count($querySemestre) !== 2) {
                throw new \Exception('Semestre não encontrado, verifique o item "Semestre vigente" no parâmetro "Matrícula" em configurações.');
            }

            #Retorno
            return $querySemestre;
        } catch (\Throwable $e) {
            #Retorno
            return $e->getMessage();
        }
    }
}