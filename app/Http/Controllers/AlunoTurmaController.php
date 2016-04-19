<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\AlunoTurma;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\AlunoTurmaService;
use Yajra\Datatables\Datatables;

class AlunoTurmaController extends Controller
{
    /**
     * @var AlunoTurmaService
     */
    private $service;

    /**
     * @var
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [

    ];

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
        $rows = \DB::table('fac_alunos_turmas')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_turmas.aluno_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_turmas.turma_id')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('fac_situacao_aluno', 'fac_alunos_turmas.situacao_id', '=', 'fac_situacao_aluno.id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_alunos_turmas.id',
                'fac_alunos.id as idAluno',
                'fac_turmas.codigo as codigo_turma',
                'fac_curriculos.codigo as codigo_curriculo',
                'fac_curriculos.nome as nome_curriculo',
                'fac_cursos.codigo as codigo_curso',
                'fac_cursos.nome as nome_curso',
                'fac_situacao_aluno.nome as situacao_aluno',
                \DB::raw('DATE_FORMAT(fac_turmas.aula_inicio, "%d/%m/%Y") as aula_inicio'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a href="edit/'.$row->id.'" title="Editar" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-xs btn-danger" title="Remover Curso/Turma"><i class="glyphicon glyphicon-remove"></i></a>';
        })->make(true);
    }


    /**
     * @param $idAlunoTurma
     * @return mixed
     */
    public function gridACursar($idAlunoTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_notas')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_notas.situacao_nota_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_notas.disciplina_id')
            ->join('fac_alunos_turmas', 'fac_alunos_turmas.id', '=', 'fac_notas.aluno_tuma_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_turmas.turma_id')
            ->where('fac_notas.aluno_tuma_id', $idAlunoTurma)
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
    public function gridCursadas($idAlunoTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_notas')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_notas.situacao_nota_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_notas.disciplina_id')
            ->join('fac_alunos_turmas', 'fac_alunos_turmas.id', '=', 'fac_notas.aluno_tuma_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_turmas.turma_id')
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
            ->join('fac_alunos_turmas', 'fac_alunos_turmas.id', '=', 'fac_notas.aluno_tuma_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_turmas.turma_id')
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
    public function getTurmas()
    {
        try {
            return $this->service->getTurmas();
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
            //dd($data);
            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
        }  catch (\Throwable $e) {var_dump($e->getMessage());exit;
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }


   /* public function edit($id)
    {
        try {
            #Recuperando o aluno
            $aluno = $this->service->find($id);

            #Tratando as datas
            $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('aluno.edit', compact('aluno', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }*/


    /*public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #tratando as rules
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }*/
}
