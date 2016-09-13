<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoDisciplinaDispensadaService;
use Seracademico\Services\Graduacao\AlunoService;
use Yajra\Datatables\Datatables;

class CurriculoAlunoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $alunoService;

    /**
     * @var AlunoDisciplinaDispensadaService
     */
    private $alunoDisciplinaDispensadaService;

    /**
     * @var array
     */
    private $loadFields = [
    ];

    /**
     * CurriculoAlunoController constructor.
     * @param AlunoService $service
     * @param AlunoDisciplinaDispensadaService $alunoDisciplinaDispensadaService
     */
    public function __construct(AlunoService $service, AlunoDisciplinaDispensadaService $alunoDisciplinaDispensadaService)
    {
        $this->alunoDisciplinaDispensadaService = $alunoDisciplinaDispensadaService;
        $this->alunoService = $service;
    }

    /**
     * @return mixed
     */
    public function gridACursar(Request $request, $idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                    where curso_atual.aluno_id = $idAluno and curso_atual.curriculo_id = fac_curriculos.id  ORDER BY curso_atual.id DESC LIMIT 1)")
                );
            })
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_alunos_notas.turma_disciplina_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            // Alterar depois de regularizar a situação das dispensadas em alunos_notas
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_disciplinas_dispensadas')
                    ->select('fac_alunos_semestres_disciplinas_dispensadas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.aluno_semestre_id')
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
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                \DB::raw('IF(pre1.codigo != "", pre1.codigo, "Não Informado") as pre1Codigo'),
                \DB::raw('IF(pre2.codigo != "", pre1.codigo, "Não Informado") as pre2Codigo'),
                \DB::raw('IF(co1.codigo  != "", pre1.codigo, "Não Informado") as co1Codigo')
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @return mixed
     */
    public function gridCursadas($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')

            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                    where curso_atual.aluno_id = $idAluno and curso_atual.curriculo_id = fac_curriculos.id  ORDER BY curso_atual.id DESC LIMIT 1)")
                );
            })
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_cursos.aluno_id')
            ->join('fac_alunos_semestres',  'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                    ->on('fac_alunos_notas.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id');
            })
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_disciplinas')
                    ->select('fac_alunos_semestres_disciplinas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->orderBy('fac_curriculo_disciplina.periodo')
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                'fac_turmas.codigo as codigoTurma',
                'fac_situacao_nota.nome as nomeSituacao',
                \DB::raw('IF(fac_alunos_notas.nota_unidade_1 != null, fac_alunos_notas.nota_unidade_1 != null, 0.0) as nota_unidade_1'),
                \DB::raw('IF(fac_alunos_notas.nota_unidade_2 != null, fac_alunos_notas.nota_unidade_2 != null, 0.0) as nota_unidade_2'),
                \DB::raw('IF(fac_alunos_notas.nota_2_chamada != null, fac_alunos_notas.nota_2_chamada != null, 0.0) as nota_2_chamada'),
                \DB::raw('IF(fac_alunos_notas.nota_final != null, fac_alunos_notas.nota_final != null, 0.0) as nota_final'),
                \DB::raw('IF(fac_alunos_notas.nota_media != null, fac_alunos_notas.nota_media != null, 0.0) as nota_media')
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @return mixed
     */
    public function gridDispensadas($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_semestres_disciplinas_dispensadas')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.aluno_semestre_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.disciplina_id')
            ->join('fac_motivos', 'fac_motivos.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.motivo_id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_alunos_semestres_disciplinas_dispensadas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_alunos_semestres_disciplinas_dispensadas.carga_horaria',
                'fac_alunos_semestres_disciplinas_dispensadas.qtd_credito',
                'fac_semestres.nome as nomeSemestre',
                'fac_motivos.nome as motivo',
                \DB::raw('IF(fac_alunos_semestres_disciplinas_dispensadas.media, fac_alunos_semestres_disciplinas_dispensadas.media, 0.0) as nota_media')
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a class="btn-floating" id="btnEditDispensada" title="Editar Histórico"><i class="material-icons">edit</i></a>
                    <a class="btn-floating" id="btnDeleteDispensada" title="Remover Hitórico"><i class="material-icons">delete</i></a>';
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
            return \Illuminate\Support\Facades\Response::json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
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
            return \Illuminate\Support\Facades\Response::json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
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
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
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
            return \Illuminate\Support\Facades\Response::json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
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