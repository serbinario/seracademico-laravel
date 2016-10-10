<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Entities\PosGraduacao\AlunoTurma;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\AlunoTurmaService;
use Yajra\Datatables\Datatables;

class AlunoTurmaController extends Controller
{
    /**
     * @var AlunoTurmaService
     */
    private $service;

    /**
     * @param AlunoTurmaService $service
     */
    public function __construct(AlunoTurmaService $service)
    {
        $this->service = $service;
    }

      /**
     * @return mixed
     */
    public function grid($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_turmas')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_situacao', 'pos_alunos_situacoes.situacao_id', '=', 'fac_situacao.id')
            ->orderBy('pos_alunos_turmas.id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_turmas.id',
                'pos_alunos.id as idAluno',
                'fac_turmas.codigo as codigo_turma',
                'fac_curriculos.codigo as codigo_curriculo',
                'fac_curriculos.nome as nome_curriculo',
                'fac_cursos.codigo as codigo_curso',
                'fac_cursos.nome as nome_curso',
                'fac_situacao.nome as situacao_aluno',
                \DB::raw('DATE_FORMAT(fac_turmas.aula_inicio, "%d/%m/%Y") as aula_inicio'),
            ]);

        #Editando a grid <a href="edit/'.$row->id.'" title="Editar" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
        #<a href="#" class="btn btn-xs btn-danger" title="Remover Curso/Turma"><i class="glyphicon glyphicon-remove"></i></a>
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a id="btnEditAlunoCurso" title="Editar" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
        })->make(true);
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

    /**
     * @return mixed
     */
    public function getCursos()
    {
        try {
            return $this->service->getCursos();
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getTurmas($idCurriculo)
    {
        try {
            return $this->service->getTurmas($idCurriculo);
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
    public function getLoadFields(Request $request)
    {
        try {
            return $this->service->load($request->get("models"));
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->store($data);

            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
        }  catch (\Throwable $e) {var_dump($e->getMessage());exit;
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {
            #Recuperando o aluno
            $dados = $this->service->edit($id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $dados = $request->all();
            
            #Executando a ação
            $this->service->update($dados, $id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Dados atualizados com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
