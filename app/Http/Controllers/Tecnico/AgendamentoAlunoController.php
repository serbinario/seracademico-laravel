<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Tecnico\AgendamentoAlunoRepository;
use Seracademico\Services\Tecnico\AgendamentoAlunoService;
use Seracademico\Validators\Tecnico\AgendamentoAlunoValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class AgendamentoAlunoController extends Controller
{
    /**
     * @var AgendamentoAlunoService
     */
    private $service;

    /**
     * @var AgendamentoAlunoValidator
     */
    private $validator;

    /**
     * @var AgendamentoAlunoRepository
     */
    private $repository;

    /**
     * @var array
     */
    private $loadFields = [

    ];

    public function __construct(AgendamentoAlunoService $service,
                                AgendamentoAlunoValidator $validator,
                                AgendamentoAlunoRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository =  $repository;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gridDisciplina($id)
    {
        #Criando a consulta
        $rows = \DB::table('pos_disciplina_agendamento_sc')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_disciplina_agendamento_sc.disciplina_id')
            ->join('pos_agendamentos_segunda_chamada', 'pos_agendamentos_segunda_chamada.id', '=', 'pos_disciplina_agendamento_sc.agendamento_sc_id')
            ->where('pos_agendamentos_segunda_chamada.id', $id)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'pos_agendamentos_segunda_chamada.id as agendamento_id'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gridAluno($id, $idagenda)
    {
        #Criando a consulta
        $rows = \DB::table('pos_agendamento_alunos')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_agendamento_alunos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->join('pos_agendamentos_segunda_chamada', 'pos_agendamentos_segunda_chamada.id', '=', 'pos_agendamento_alunos.agendamento_sc_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_agendamento_alunos.disciplina_id')
            ->where('pos_agendamentos_segunda_chamada.id', $idagenda)
            ->where('fac_disciplinas.id', $id)
            ->select([
                'pos_agendamento_alunos.id',
                'pessoas.nome',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Html de Retorno
            $html = '<a title="Remover Aluno" id="btnRemoverAluno" href="#" class="btn-floating red"><i class="material-icons">delete</i></a>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Aluno removido com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLoadFieldsAluno()
    {
        #Criando a consulta
        $alunos = \DB::table('pos_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->leftJoin('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->leftJoin('fac_situacao', 'fac_situacao.id', '=', 'pos_alunos_situacoes.situacao_id')
            ->leftJoin('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
            ->leftJoin('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('pos_tipos_alunos', 'pos_tipos_alunos.id', '=', 'pos_alunos.tipo_aluno_id')
            ->where('pos_tipos_alunos.id', 3)
            ->select([
                'pos_alunos.id',
                'pessoas.nome',
            ])->get();

        return \Illuminate\Support\Facades\Response::json($alunos);
    }
}
