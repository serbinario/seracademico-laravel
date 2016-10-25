<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\AlunoNotaService;
use Seracademico\Services\PosGraduacao\TurmaService;
use Yajra\Datatables\Datatables;

class TurmaNotaController extends Controller
{
    /**
     * @var TurmaService
     */
    private $turmaService;

    /**
     * @var AlunoNotaService
     */
    private $alunoNotaService;

    /**
     * TurmaNotaController constructor.
     * @param TurmaService $turmaService
     * @param AlunoNotaService $alunoNotaService
     */
    public function __construct(TurmaService $turmaService, AlunoNotaService $alunoNotaService)
    {
        $this->turmaService     = $turmaService;
        $this->alunoNotaService = $alunoNotaService;
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
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome as nome_disciplina',
                'pos_alunos_notas.id as idAlunoNota',
                'pos_alunos.id as idAluno',
                'pessoas.nome as nomePessoa',
                'pos_alunos_notas.nota_final',
                'fac_situacao_nota.nome as situacao'
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
            ->addColumn('action', function ($row) {
                # html de retorno
                $html = '<a title="Editar notas" id="btnEditarNotas"  href="#" class="btn-floating red"><i class="material-icons">edit</i></a>';

                # retorno
                return $html;
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
     * @param $id
     * @return mixed
     */
    public function editNota($id)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $row   = $this->alunoNotaService->search($id);
            $data  = [];
            
            # Preparando o array de retorno
            $data['nota_final']   = $row[0]->nota_final;
            $data['situacao_id']  = $row[0]->idSituacao;
            $data['nomeSituacao'] = $row[0]->nomeSituacao;
            $data['nomePessoa']   = $row[0]->nomePessoa;

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateNota(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->alunoNotaService->update($data, $id);

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
//
//    /**
//     * @param $id
//     * @return mixed
//     */
//    public function delete($id)
//    {
//        try {
//            #Executando a ação
//            $this->service->delete($id);
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Calendário removido com sucesso!']);
//        } catch (ValidatorException $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }

}
