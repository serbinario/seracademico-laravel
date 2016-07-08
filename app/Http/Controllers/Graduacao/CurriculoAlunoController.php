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

class CurriculoAlunoController extends Controller
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
     * @return mixed
     */
    public function gridACursar(Request $request, $idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
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
                $query->from('fac_alunos_semestres_disciplinas')
                    ->select('fac_alunos_semestres_disciplinas.disciplina_id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas.aluno_semestre_id')
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
                'fac_cursos.nome as nomeCurso'
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
                'fac_alunos_notas.nota_media',
                'fac_turmas.codigo as codigoTurma',
                'fac_situacao_nota.nome as nomeSituacao'
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