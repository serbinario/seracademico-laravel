<?php

namespace Seracademico\Http\Controllers\Mestrado;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Mestrado\AlunoFrequenciaService;
use Seracademico\Repositories\Mestrado\AlunoNotaRepository;
use Seracademico\Services\Mestrado\TurmaService;
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
     * @var AlunoNotaRepository
     */
    private $alunoNotaRepository;

    /**
     * TurmaFrequenciaController constructor.
     * @param TurmaService $turmaService
     * @param AlunoFrequenciaService $alunoFrequenciaService
     * @param AlunoNotaRepository $alunoNotaRepository
     */
    public function __construct(TurmaService $turmaService,
                                AlunoFrequenciaService $alunoFrequenciaService,
                                AlunoNotaRepository $alunoNotaRepository)
    {
        $this->turmaService = $turmaService;
        $this->alunoFrequenciaService = $alunoFrequenciaService;
        $this->alunoNotaRepository = $alunoNotaRepository;
    }

    /**
     * @return mixed
     */
    public function grid(Request $request, $idTurma)
    {
        $rows = \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_notas', 'pos_alunos_notas.pos_aluno_turma_id', '=', 'pos_alunos_turmas.id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_notas.turma_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome as nome_disciplina',
                'pos_alunos_notas.id as idAlunoNota',
                'pos_alunos.id as idAluno',
                'pessoas.nome as nomePessoa',
                \DB::raw('IF(pos_alunos_turmas.turma_id = pos_alunos_notas.turma_id, "Corrente", "Reposição de Aula") as status')
            ])
            ->where('fac_turmas.id', '=', $idTurma);
        
//        $rows = \DB::table('pos_alunos_notas')
//            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'pos_alunos_notas.pos_aluno_turma_id')
//            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
//            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_notas.turma_id')
//            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
//            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
//            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
//            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
//            ->select([
//                'fac_disciplinas.id',
//                'fac_disciplinas.nome as nome_disciplina',
//                'pos_alunos_notas.id as idAlunoNota',
//                'pos_alunos.id as idAluno',
//                'pessoas.nome as nomePessoa'
//            ])
//            ->where('fac_turmas.id', '=', $idTurma);


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
                $html = '<form class="form-inline">';

                # Recuperando as frequências
                $frequencias = $this->alunoNotaRepository->find($row->idAlunoNota)->frequencias()->get();

                # Percorrendo as freuências
                foreach ($frequencias as $frequencia) {
                    $html .= '<div class="form-group">                               
                                    <input '. ($frequencia->frequencia == 1 ? 'checked="true"' : '') .'" class="frequencia" 
                                        value="'. $frequencia->id .'" type="checkbox"/> '. $frequencia->calendario->data_final .'                                                                     
                              </div>';
                }

                # html de retorno
                $html .= '</form>';

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
     * @param Request $request
     * @return mixed
     *
     */
    public function changeFrequencia(Request $request, $id)
    {
        try {
            # Mensagem de retorno
            $mensagem = "";

            # Recuperando a frequência
            $frequencia = $this->alunoFrequenciaService->find($id);
            $statusFreq = $request->get('frequencia') === "true" ? true : false;

            # Alterando a frequência
            $frequencia->frequencia = $statusFreq;
            $frequencia->save();
          
            # Tratando a mensagem
            if($statusFreq) {
                $mensagem = "Falta atrubuída com sucesso!";
            } else {
                $mensagem = "Falta retirada com sucesso!";
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => $mensagem]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
