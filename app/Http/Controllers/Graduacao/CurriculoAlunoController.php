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
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join(\DB::raw('(SELECT fac_alunos_cursos.* FROM fac_alunos_cursos ORDER BY fac_alunos_cursos.id DESC LIMIT 1)fac_alunos_cursos'), function ($join) {
                $join->on('fac_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id');
            })
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
            ->join(\DB::raw('(SELECT fac_alunos_cursos.* FROM fac_alunos_cursos ORDER BY fac_alunos_cursos.id DESC LIMIT 1)fac_alunos_cursos'), function ($join) {
                $join->on('fac_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id');
            })
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_disciplinas.id', function ($query) use ($idAluno) {
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