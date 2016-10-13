<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\AlunoService;
use Yajra\Datatables\Datatables;

class AlunoCurriculoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * AlunoCurriculoController constructor.
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $idAlunoTurma
     * @return mixed
     */
    public function gridACursar($idAlunoTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
            ->where('pos_alunos_turmas.id', $idAlunoTurma)
            ->select([
                'pos_alunos_turmas.madia as media',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_turmas.codigo as turma_codigo',
                'fac_disciplinas.nome as situacao_nota_nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idAlunoTurma
     * @return mixed
     */
    public function gridCursadas($idAlunoTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_notas')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_notas.situacao_nota_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_notas.disciplina_id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'fac_notas.aluno_tuma_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->where('fac_notas.aluno_tuma_id', $idAlunoTurma)
            ->where('fac_situacao_nota.id', 'in', [1,2])
            ->select([
                'fac_notas.media',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_turmas.codigo as turma_codigo',
                'fac_situacao_nota.nome as situacao_nota_nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idAlunoTurma
     * @return mixed
     */
    public function gridDispensadas($idAlunoTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_notas')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_notas.situacao_nota_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_notas.disciplina_id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'fac_notas.aluno_tuma_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->where('fac_notas.aluno_tuma_id', $idAlunoTurma)
            ->where('fac_situacao_nota.id', '=', 4)
            ->select([
                'fac_notas.media',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_turmas.codigo as turma_codigo',
                'fac_situacao_nota.nome as situacao_nota_nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }
}
