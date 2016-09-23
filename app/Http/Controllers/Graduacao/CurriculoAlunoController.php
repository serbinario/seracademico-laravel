<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoDisciplinaEletivaService;
use Seracademico\Services\Graduacao\AlunoDisciplinaExtraCurricularService;
use Seracademico\Services\Graduacao\AlunoDisciplinaDispensadaService;
use Seracademico\Services\Graduacao\AlunoService;
use Seracademico\Uteis\ConsultationsBuilders\Aluno\BuildersExtraCurricular;
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
     * @var AlunoDisciplinaExtraCurricularService
     */
    private $alunoDisciplinaExtraCurricularService;

    /**
     * @var AlunoDisciplinaEletivaService
     */
    private $alunoDisciplinaEletivaService;

    /**
     * CurriculoAlunoController constructor.
     * @param AlunoService $service
     * @param AlunoDisciplinaDispensadaService $alunoDisciplinaDispensadaService
     * @param AlunoDisciplinaExtraCurricularService $alunoDisciplinaExtraCurricularService
     * @param AlunoDisciplinaEletivaService $alunoDisciplinaEletivaService
     */
    public function __construct(AlunoService $service,
        AlunoDisciplinaDispensadaService $alunoDisciplinaDispensadaService,
        AlunoDisciplinaExtraCurricularService $alunoDisciplinaExtraCurricularService,
        AlunoDisciplinaEletivaService $alunoDisciplinaEletivaService)
    {
        $this->alunoService = $service;
        $this->alunoDisciplinaDispensadaService = $alunoDisciplinaDispensadaService;
        $this->alunoDisciplinaExtraCurricularService = $alunoDisciplinaExtraCurricularService;
        $this->alunoDisciplinaEletivaService = $alunoDisciplinaEletivaService;
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
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
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
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_semestres_eletivas')
                    ->select('fac_alunos_semestres_eletivas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_eletivas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->union(BuildersExtraCurricular::getExtraCurricularACursar($idAluno))
            ->union(BuildersExtraCurricular::getEletivasACursar($idAluno))
            ->orderBy('periodo')
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
    public function gridCursando($idAluno)
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
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                    ->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_notas.turma_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_situacao_nota.id', [10]) // Situação de cumprimento da disciplina
            ->union(BuildersExtraCurricular::getExtraCurricularCursando($idAluno))
            ->union(BuildersExtraCurricular::getEletivasCursando($idAluno))
            ->orderBy('periodo')
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
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                    ->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_notas.turma_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_situacao_nota.id', [1,2,6,7]) // Situação de cumprimento da disciplina
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
            ->leftJoin('fac_motivos', 'fac_motivos.id', '=', 'fac_alunos_semestres_disciplinas_dispensadas.motivo_id')
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
     * @return mixed
     */
    public function gridExtraCurricular(Request $request, $idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_semestres_disciplinas_extras')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_disciplinas_extras.disciplina_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_semestres_disciplinas_extras.curriculo_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_extras.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->where('fac_alunos.id', $idAluno)
            ->orderBy('fac_curriculo_disciplina.periodo')
            ->select([
                'fac_alunos_semestres_disciplinas_extras.id',
                'fac_alunos_semestres.id as aluno_semestre_id',
                'fac_disciplinas.id as disciplina_id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'pessoas.nome as nomeAluno',
                'fac_curriculos.codigo as codigoCurriculo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Variável que armazenará o html
            $html = "";

            # Recuperando os registros da validação
            $rowsNotas = \DB::table('fac_alunos_notas')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                ->where('fac_alunos_notas.aluno_semestre_id', $row->aluno_semestre_id)
                ->where('fac_disciplinas.id', $row->disciplina_id)
                ->select(['fac_alunos_notas.id'])->get();

            # Validando se veio registro
            if(count($rowsNotas) == 0) {
                $html .= '<a class="btn-floating" id="btnDeleteDisciplinaExtraCurricular" title="Remover disciplina"><i class="material-icons">delete</i></a>';
            }

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function gridEletiva($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->join('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
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
            ->leftJoin('fac_alunos_semestres_eletivas', 'fac_alunos_semestres_eletivas.disciplina_id', '=', 'fac_disciplinas.id')
            ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_semestres_eletivas.turma_id')
            ->leftJoin('fac_disciplinas as eletiva', 'eletiva.id', '=', 'fac_alunos_semestres_eletivas.disciplina_eletiva_id')
            ->leftJoin('fac_curriculos as curriculoEletiva', 'curriculoEletiva.id', '=', 'fac_turmas.curriculo_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->where('fac_tipo_disciplinas.id', 2)
            ->orderBy('fac_curriculo_disciplina.periodo')
            ->select([
                'fac_alunos_semestres_eletivas.id as idEletiva',
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_curriculo_disciplina.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_curriculos.codigo as codigoCurriculo',
                'fac_curriculo_disciplina.id as idCurriculoDisciplinaEletiva',
                'eletiva.codigo as codigoEletiva',
                'eletiva.id as disciplinaEletivaId',
                'curriculoEletiva.codigo as codigoCurriculoEletiva',
                'fac_alunos_semestres.id as aluno_semestre_id'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Variável que armazenará o html
            $html = '';

            # Recuperando os registros da validação
            $rowsNotas = \DB::table('fac_alunos_notas')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                ->where('fac_alunos_notas.aluno_semestre_id', $row->aluno_semestre_id)
                ->where('fac_disciplinas.id', $row->disciplinaEletivaId)
                ->select(['fac_disciplinas.id'])->get();

            # Validando se veio registro
            if($row->id && count($rowsNotas) == 0) {
                $html .= '<a class="btn-floating" id="btnAttachEletiva" title="Adicionar disciplina eletiva"><i class="material-icons">add-to-photos</i></a>';
                $html .= '<a class="btn-floating" id="btnDetachEletiva" title="Remover disciplina adicionada"><i class="material-icons">cancel</i></a>';
            }

            # Retorno
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
    public function storeDisciplinaEletiva(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();

            # Persistindo os dados no banco de dados
            $this->alunoDisciplinaEletivaService->store($dados);

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
    public function deleteDisciplinaEletiva($id)
    {
        try {
            # Removendo do banco de dados
            $this->alunoDisciplinaEletivaService->delete($id);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Dados removidos com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
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
}