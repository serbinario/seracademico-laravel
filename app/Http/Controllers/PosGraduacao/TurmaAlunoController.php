<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Repositories\PosGraduacao\TurmaRepository;
use Seracademico\Services\PosGraduacao\TurmaService;
use Yajra\Datatables\Datatables;

class TurmaAlunoController extends Controller
{
    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var TurmaRepository
     */
    private $turmaRepository;

    /**
     * @var TurmaService
     */
    private $turmaService;

    /**
     * TurmaAlunoController constructor.
     * @param TurmaRepository $turmaRepository
     * @param AlunoRepository $alunoRepository
     * @param TurmaService $turmaService
     */
    public function __construct(TurmaRepository $turmaRepository, AlunoRepository $alunoRepository, TurmaService $turmaService)
    {
        $this->alunoRepository = $alunoRepository;
        $this->turmaRepository = $turmaRepository;
        $this->turmaService = $turmaService;
    }

    /**
     * @return mixed
     */
    public function grid(Request $request, $idTurma)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_notas')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'pos_alunos_notas.pos_aluno_turma_id')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_notas.turma_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
            ->join('fac_turmas_disciplinas', function ($join) {
                $join->on('fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
                    ->on('fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->leftJoin('fac_calendarios', 'fac_calendarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->groupBy('pos_alunos.id')
            ->where('fac_turmas.id', '=', $idTurma)
            ->select([
                'pessoas.nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                # Filtranto por disciplina
                if ($request->has('disciplina')) {
                    $query->where('fac_disciplinas.id', '=', $request->get('disciplina'));
                }

                # Filtranto por calendario
                if ($request->has('calendario')) {
                    $query->where('fac_calendarios.id', '=', $request->get('calendario'));
                }
            })->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->turmaService->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idCurso
     * @param $idTurma
     * @param $idDisciplina
     * @return mixed
     */
    public function getAlunosByCurso($idCurso, $idTurma, $idDisciplina)
    {
        try {
            # Recuperando os alunos
            $alunos = \DB::table('pos_alunos')
                ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
                ->join('pos_alunos_cursos', function ($join) {
                    $join->on(
                        'pos_alunos_cursos.id', '=',
                        \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->join('pos_alunos_turmas', function ($join) {
                    $join->on(
                        'pos_alunos_turmas.id', '=',
                        \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                    );
                })
                ->join('pos_alunos_notas','pos_alunos_notas.pos_aluno_turma_id', '=', 'pos_alunos_turmas.id')
                ->groupBy('pos_alunos.id')
                ->where('fac_cursos.id', $idCurso)
                ->where('pos_alunos_turmas.turma_id', '!=', $idTurma)
                ->select([
                    'pos_alunos.id',
                    'pessoas.nome'
                ])->get();

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $alunos]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function attachAluno(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Verificando os parâmetros da requisição
            if(count($dados) != 3) {
                throw new \Exception('Voçê deve preencher todos os campos');
            }

            # Recuperando o aluno
            $aluno = $this->alunoRepository->find($dados['aluno_id']);
            $notas = $aluno->curriculos()->get()->last()->pivot
                ->turmas()->get()->last()->pivot
                ->notas()->get();

            # Percorrendo todas as notas
            foreach ($notas as $nota) {
                if($nota->disciplina_id == $request->get('disciplina_id')) {
                    $nota->turma_id = $request->get('turma_id');
                    $nota->save();
                }
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Aluno Adicionado com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
