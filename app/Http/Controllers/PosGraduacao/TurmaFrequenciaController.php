<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
//use Seracademico\Services\PosGraduacao\AlunoFrequenciaService;
use Seracademico\Services\PosGraduacao\TurmaService;
use Yajra\Datatables\Datatables;

class TurmaFrequenciaController extends Controller
{
    /**
     * @var TurmaService
     */
    private $turmaService;

    /**
     * @var AlunoFrequenciaService
     */
    private $alunoFrequenciaService;

    /**
     * TurmaFrequenciaController constructor.
     * @param TurmaService $turmaService
     * @param AlunoFrequenciaService $alunoFrequenciaService
     */
    public function __construct(TurmaService $turmaService, AlunoFrequenciaService $alunoFrequenciaService)
    {
        $this->turmaService = $turmaService;
        $this->alunoFrequenciaService = $alunoFrequenciaService;
    }

    /**
     * @return mixed
     */
    public function grid(Request $request, $idTurma)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_frequencias')
            ->join('pos_alunos_notas', 'pos_alunos_notas.id', '=', 'pos_alunos_frequencias.pos_aluno_nota_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'pos_alunos_notas.pos_aluno_turma_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->select([
                'pos_alunos_frequencias.id',
                'pessoas.nome as nomePessoa'
            ])
            ->where('fac_turmas.id', '=', $idTurma);

        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                # Filtranto por disciplina
                if ($request->has('disciplina')) {
                    $query->where('fac_disciplinas.id', '=', $request->get('disciplina'));
                } else {
                    $query->where('fac_disciplinas.id', '=', 0);
                }
            })
            ->addColumn('frequencia', function ($row) {
                # html de retorno
                $html = '<a title="Editar notas" id="btnEditarFrequencias"  href="#" class="btn-floating red"><i class="material-icons">edit</i></a>';

                # retorno
                return $html;
        })->make(true);
    }

//    /**
//     * @param Request $request
//     * @return mixed
//     *
//     */
//    public function getLoadFields(Request $request)
//    {
//        try {
//            return $this->turmaService->load($request->get("models"), true);
//        } catch (\Throwable $e) {
//            return \Illuminate\Support\Facades\Response::json([
//                'error' => $e->getMessage()
//            ]);
//        }
//    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateFrequencia(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->alunoFrequenciaService->update($data, $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
