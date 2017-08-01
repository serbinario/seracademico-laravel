<?php

namespace Seracademico\Http\Controllers\Doutorado;

use Illuminate\Http\Request;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Doutorado\AlunoDisciplinaDispensadaService;
use Seracademico\Services\Doutorado\AlunoDisciplinaEquivalenteService;
use Seracademico\Services\Doutorado\AlunoDisciplinaExtraCurricularService;
use Seracademico\Services\Doutorado\AlunoService;
use Seracademico\Uteis\ConsultationsBuilders\Aluno\PosGraduacao\BuildersUniosCurriculo;
use Yajra\Datatables\Datatables;

class AlunoCurriculoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;
    
    /**
     * @var AlunoDisciplinaDispensadaService
     */
    private $alunoDisciplinaDispensadaService;

    /**
     * @var AlunoDisciplinaExtraCurricularService
     */
    private $alunoDisciplinaExtraCurricularService;

    /**
     * @var AlunoDisciplinaEquivalenteService
     */
    private $alunoEquivalenciaService;

    /**
     * AlunoCurriculoController constructor.
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service,
                                AlunoDisciplinaDispensadaService $alunoDisciplinaDispensadaService,
                                AlunoDisciplinaExtraCurricularService $alunoDisciplinaExtraCurricularService,
                                AlunoDisciplinaEquivalenteService $alunoEquivalenciaService)
    {
        $this->service = $service;
        $this->alunoDisciplinaDispensadaService = $alunoDisciplinaDispensadaService;
        $this->alunoDisciplinaExtraCurricularService = $alunoDisciplinaExtraCurricularService;
        $this->alunoEquivalenciaService = $alunoEquivalenciaService;
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridACursar($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_cursos')
            ->leftJoin('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_curriculo_disciplina.disciplina_id')
            // Alterar depois de regularizar a situação das dispensadas em alunos_notas
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('pos_alunos')
                    ->join('pos_alunos_cursos', function ($join) {
                        $join->on(
                            'pos_alunos_cursos.id', '=',
                            \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                            where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                        );
                    })
                    ->join('pos_alunos_dispensadas', 'pos_alunos_dispensadas.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_dispensadas.disciplina_id')
                    ->where('pos_alunos.id', $idAluno)
                    ->select([
                        'fac_disciplinas.id'
                    ]);
            })
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('pos_alunos')
                    ->join('pos_alunos_cursos', function ($join) {
                        $join->on(
                            'pos_alunos_cursos.id', '=',
                            \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                            where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                        );
                    })
                    ->join('pos_alunos_equivalencias', 'pos_alunos_equivalencias.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_equivalencias.disciplina_id')
                    ->where('pos_alunos.id', $idAluno)
                    ->select([
                        'fac_disciplinas.id'
                    ]);
            })
            ->where('pos_alunos.id', $idAluno)
            ->union(BuildersUniosCurriculo::getExtraCurricularACursar($idAluno))
            ->union(BuildersUniosCurriculo::getEquivalenciasACursar($idAluno))
            ->select([
                'pos_alunos_cursos.id',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_turmas.codigo as turma_codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito'
            ]);


        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridCursadas($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_cursos')
            ->join('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('pos_alunos_notas', 'pos_alunos_notas.pos_aluno_turma_id', '=', 'pos_alunos_turmas.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_notas.disciplina_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
            ->where('pos_alunos.id', $idAluno)
            ->whereIn('fac_situacao_nota.id', [1]) // Situação de cumprimento da disciplina
            ->select([
                'pos_alunos_cursos.id',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_turmas.codigo as turma_codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito',
                'pos_alunos_notas.nota_final',
                'fac_situacao_nota.nome as situacao'
            ]);
        
        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridDispensadas($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_dispensadas', 'pos_alunos_dispensadas.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_dispensadas.disciplina_id')
            ->join('fac_motivos', 'fac_motivos.id', '=', 'pos_alunos_dispensadas.motivo_id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_dispensadas.id',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.nome as disciplina_nome',
                'pos_alunos_dispensadas.carga_horaria',
                'pos_alunos_dispensadas.nota_final',
                'pos_alunos_dispensadas.qtd_credito',
                'fac_motivos.nome as motivo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html  = "";
            $html .= '<a class="btn-floating" id="btnEditDisciplinaDispensada" title="Remover dispensa"><i class="material-icons">edit</i></a></li>';
            $html .= '<a class="btn-floating" id="btnDeleteDisciplinaDispensada" title="Remover dispensa"><i class="material-icons">delete</i></a></li>';

            return $html;
        })->make(true);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridDisciplinasExtraCurricular($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_extras', 'pos_alunos_extras.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_extras.disciplina_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_extras.curriculo_id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_extras.id',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito',
                'fac_curriculos.codigo as codigoCurriculo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html  = "";
            $html .= '<a class="btn-floating" id="btnDeleteDisciplinaExtraCurricular" title="Remover dispensa"><i class="material-icons">delete</i></a></li>';

            return $html;
        })->make(true);
    }
    
    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridDisciplinasEquivalentes($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_equivalencias', 'pos_alunos_equivalencias.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->join('fac_disciplinas as equivalente', 'equivalente.id', '=', 'pos_alunos_equivalencias.disciplina_equivalente_id')
            ->join('fac_curriculos as curriculo_equivalente', 'curriculo_equivalente.id', '=', 'pos_alunos_equivalencias.curriculo_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_equivalencias.disciplina_id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_equivalencias.id',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito',
                'equivalente.codigo as equivalente_codigo',
                'curriculo_equivalente.codigo as codigoCurriculo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html  = "";
            $html .= '<a class="btn-floating" id="btnDeleteEquivalencia" title="Remover equivalência"><i class="material-icons">delete</i></a></li>';

            return $html;
        })->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeDispensada(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Persistindo os dados no banco de dados
            $this->alunoDisciplinaDispensadaService->store($dados);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados cadastrados com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteDispensada($id)
    {
        try {
            # Removendo do banco de dados
            $this->alunoDisciplinaDispensadaService->delete($id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados removidos com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function editDispensada($id)
    {
        try {
            #recuperando a dispensa
            $dispensada = $this->alunoDisciplinaDispensadaService->find($id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'dados' => $dispensada]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateDispensada(Request $request, $id)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Persistindo os dados no banco de dados
            $this->alunoDisciplinaDispensadaService->update($dados, $id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados atualizados com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idCurriculo
     * @return mixed
     */
    public function getDisciplinasByCurriculo($idCurriculo)
    {
        try {
            # Query de busca das discplinas do currículo ($idCurriculo)
            $rows = \DB::table('fac_disciplinas')
                ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
                ->where('fac_curriculos.id', $idCurriculo)
                ->select(['fac_disciplinas.id', 'fac_disciplinas.nome', 'fac_disciplinas.codigo'])->get();

            # Verificando se os registros foram encontrados
            if(count($rows) === 0) {
                throw new \Exception('Nenhum resultado encontrado!');
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $rows]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeDisciplinaExtraCurricular(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Persistindo os dados no banco de dados
            $this->alunoDisciplinaExtraCurricularService->store($dados);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados cadastrados com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteDisciplinaExtraCurricular($id)
    {
        try {
            # Removendo do banco de dados
            $this->alunoDisciplinaExtraCurricularService->delete($id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados removidos com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeEquivalencia(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Persistindo os dados no banco de dados
            $this->alunoEquivalenciaService->store($dados);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Dados cadastrados com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteEquivalencia($id)
    {
        try {
            # Removendo do banco de dados
            $this->alunoEquivalenciaService->delete($id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados removidos com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}