<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
//use Seracademico\Services\CalendarioDisciplinaTurmaService;
use Seracademico\Services\Graduacao\AlunoNotaService;
use Seracademico\Services\Graduacao\TurmaService;
//use Seracademico\Validators\CalendarioDisciplinaTurmaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;

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
        $rows = \DB::table('fac_disciplinas')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->on('fac_alunos_notas.turma_id', '=', 'fac_turmas.id');
            })
            ->leftJoin('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->leftJoin('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.id as idDiciplina',
                'fac_alunos_notas.id as idAlunoNota',
                'fac_alunos_semestres.id as idAlunoSemestre',
                'fac_alunos.id as idAluno',
                'pessoas.nome as nomePessoa',
                'fac_alunos_notas.nota_unidade_1',
                'fac_alunos_notas.nota_unidade_2',
                'fac_alunos_notas.nota_2_chamada',
                'fac_alunos_notas.nota_final',
                'fac_alunos_notas.nota_media',
                'fac_situacao_nota.nome as nomeSituacao',
                'fac_alunos_frequencias.total_falta'
            ])
            ->where('fac_turmas.id', '=', $idTurma)->toSql();
            dd($rows);

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
            $data['nota_unidade_1'] = $row[0]->nota_unidade_1;
            $data['nota_unidade_2'] = $row[0]->nota_unidade_2;
            $data['nota_2_chamada'] = $row[0]->nota_2_chamada;
            $data['nota_final']     = $row[0]->nota_final;
            $data['nota_media']     = $row[0]->nota_media;
            $data['total_falta']    = $row[0]->total_falta;
            $data['situacao_id']    = $row[0]->idSituacao;
            $data['nomeSituacao']   = $row[0]->nomeSituacao;
            $data['nomePessoa']     = $row[0]->nomePessoa;

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
