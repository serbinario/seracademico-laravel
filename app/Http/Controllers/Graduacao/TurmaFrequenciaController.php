<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoFrequenciaService;
use Seracademico\Services\Graduacao\TurmaService;
//use Seracademico\Validators\CalendarioDisciplinaTurmaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;

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
        $rows = \DB::table('fac_turmas_disciplinas')
            ->join('fac_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_alunos_notas', 'fac_alunos_notas.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
            ->join('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
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
            ->addColumn('action', function ($row) {
                # html de retorno
                $html = '<a title="Editar notas" id="btnEditarFrequencias"  href="#" class="btn-floating red"><i class="material-icons">edit</i></a>';

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
    public function editFrequencia($id)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $row   = $this->alunoFrequenciaService->search($id);
            $data  = [];
            
            # Preparando o array de retorno
            $data['falta_mes_1']  = $row[0]->falta_mes_1;
            $data['falta_mes_2']  = $row[0]->falta_mes_2;
            $data['falta_mes_3']  = $row[0]->falta_mes_3;
            $data['falta_mes_4']  = $row[0]->falta_mes_4;
            $data['falta_mes_5']  = $row[0]->falta_mes_5;
            $data['falta_mes_6']  = $row[0]->falta_mes_6;
            $data['total_falta']  = $row[0]->total_falta;
            $data['nomePessoa']   = $row[0]->nomePessoa;

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

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
