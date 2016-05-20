<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\AlunoService;
use Seracademico\Validators\AlunoValidator;
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
        #Criando a consulta
        $alunos = \DB::table('fac_alunos')
            ->join('inclusao_aluno', 'inclusao_aluno.aluno_id', '=', 'fac_alunos.id')
            ->where('inclusao_aluno.data_inclusao', '!=', '')
            ->select([
                'fac_alunos.id',
                'fac_alunos.nome',
                'fac_alunos.cpf',
                'fac_alunos.matricula',
                'fac_alunos.celular'
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
            ->join('inclusao_aluno', 'inclusao_aluno.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'inclusao_aluno.aluno_id')
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
                    'fac_alunos.nome as nomeAluno',
                    'fac_cursos.nome as nomeCurso']
            );

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
                ->select(['fac_disciplinas.id', 'fac_disciplinas.codigo as codigoDisciplina', 'fac_disciplinas.nome as nomeDisciplina'])->get();

            # Tratanto os dados de retorno
            $count = 0;
            foreach ($rows as $row) {
                # variárel que armazenará o array de turmas
                $arrayTurmas = [];

                # Carregando a disciplina
                $dados[$count]['nomeDisciplina']   = $row->nomeDisciplina;
                $dados[$count]['codigoDisciplina'] = $row->codigoDisciplina;

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
            ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                    ->join('alunos_horarios', 'alunos_horarios.horario_id', '=', 'fac_horarios.id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'alunos_horarios.aluno_id')
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
                ->join("alunos_horarios", 'alunos_horarios.horario_id', "=", "fac_horarios.id")
                ->join("fac_alunos", "fac_alunos.id", "=", "alunos_horarios.aluno_id")
                ->where('fac_turmas_disciplinas.id', $dados['idTurmaDisciplina'])
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
                ->select('fac_horarios.id')
                ->lists('fac_horarios.id');

            # Recuperando o aluno
            $aluno = $this->alunoService->find($dados['idAluno']);
            $aluno->horarios()->attach($rows);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}