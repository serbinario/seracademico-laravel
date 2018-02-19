<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoService;
use Yajra\Datatables\Datatables;

class SemestreAlunoController extends Controller
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
     * @param Request $request
     * @return mixed
     */
    public function getTurmas(Request $request, $idAluno, $idSemestre)
    {
        try {
            # Variável que armazenará o array de retorno
            $dados = [];

            # Fazendo a consulta pincipal e recuperando os registros
            $rows  = \DB::table('fac_disciplinas')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
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
                    'fac_disciplinas.codigo as codigoDisciplina',
                    'fac_disciplinas.nome as nomeDisciplina',
                    'fac_turmas.codigo as codigoTurma'
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
                $dados[$count]['codigoTurma']      = $row->codigoTurma;

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
    public function gridHorario($idAluno, $idSemestre)
    {
        #Criando a consulta
        $rows = \DB::table('fac_horarios')
            ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.horario_id', '=', 'fac_horarios.id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_horarios.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
            ->where('fac_alunos.id', $idAluno)
            ->where('fac_semestres.id', $idSemestre)
            ->groupBy('fac_horas.id')
            ->orderBy('fac_horas.id')
            ->select([
                'fac_horarios.id',
                'fac_horas.id as hora',
                \DB::raw('CONCAT(DATE_FORMAT(fac_horas.hora_inicial, "%k:%i"), " - ", DATE_FORMAT(fac_horas.hora_final, "%k:%i")) as horario'),
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
                    ->where('fac_horas.id', $row->hora)
                    ->where('fac_alunos.id', $row->idAluno)
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
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
                    ->where('fac_semestres.id', $row->idSemestre)
                    ->where('fac_horarios.dia_id', 7)->get();

                return $result[0]->codigo ?? "";
            })->make(true);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridNotas($idAluno, $idSemestre)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_notas')
            ->leftJoin('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->leftJoin('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_disciplinas', 'fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_alunos_notas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_turmas_disciplinas', function ($join) {
                $join->on('fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
                    ->on('fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->where('fac_alunos.id', $idAluno)
            ->where('fac_semestres.id', $idSemestre)
            ->select([
                'fac_turmas_disciplinas.id',
                'fac_disciplinas.id as idDiciplina',
                'fac_alunos_notas.nota_unidade_1',
                'fac_alunos_notas.nota_unidade_2',
                'fac_alunos_notas.nota_2_chamada',
                'fac_alunos_notas.nota_final',
                'fac_alunos_notas.nota_media',
                'fac_situacao_nota.nome as nomeSituacao',
                'fac_alunos_frequencias.total_falta',
                'fac_disciplinas.nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @return mixed
     */
    public function gridFaltas(Request $request, $idAluno, $idSemestre)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_notas')
            ->join('fac_disciplinas', 'fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_alunos_notas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->where('fac_alunos.id', $idAluno)
            ->where('fac_semestres.id', $idSemestre)
            ->select([
                'fac_alunos_frequencias.id',
                'fac_alunos_frequencias.falta_mes_1',
                'fac_alunos_frequencias.falta_mes_2',
                'fac_alunos_frequencias.falta_mes_3',
                'fac_alunos_frequencias.falta_mes_4',
                'fac_alunos_frequencias.falta_mes_5',
                'fac_alunos_frequencias.falta_mes_6',
                'fac_alunos_frequencias.total_falta',
                'fac_situacao_nota.nome as nomeSituacao',
                'fac_disciplinas.nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->alunoService->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }
}