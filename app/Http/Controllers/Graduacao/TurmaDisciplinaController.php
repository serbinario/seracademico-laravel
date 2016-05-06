<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
//use Seracademico\Services\CalendarioDisciplinaTurmaService;
use Seracademico\Services\Graduacao\TurmaService;
//use Seracademico\Validators\CalendarioDisciplinaTurmaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;

class TurmaDisciplinaController extends Controller
{
    /**
     * @var TurmaService
     */
    private $turmaService;

    /**
     * @var
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Professor',
        'Sala'
    ];

    /**
     * @param TurmaService $turmaService
     */
    public function __construct(TurmaService $turmaService)
    {
        $this->turmaService = $turmaService;
    }

    /**
     * @return mixed
     */
    public function grid($idTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_turmas_disciplinas')
            ->join('fac_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->select([
                'fac_disciplinas.codigo',
                'fac_turmas_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.id as idDisciplina',
                'fac_curriculos.id as idCurriculo',
                'fac_turmas.periodo',
                'fac_turmas.id as idTurma',
                'fac_disciplinas.id as idDisciplina'
            ])
            ->where('fac_turmas.id', '=', $idTurma);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html  = '';

            $turma           = $this->turmaService->find($row->idTurma);
            $disciplina      = $turma->disciplinas()->find($row->idDisciplina);
            $turmaDisciplina = $disciplina->pivot;

            if(isset($turmaDisciplina->horarios) && count($turmaDisciplina->horarios) == 0) {
                $html = '<a title="Remover Disciplina" id="removerDisciplina"  href="#" class="btn-floating red"><i class="material-icons">delete</i></a>';
            }

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
     */
    public function store(Request $request)
    {
        try {
            #incluindo disciplina as Disciplinas
            $this->turmaService->incluirDisciplina($request->all());

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Inclusão realizada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete(Request $request)
    {
        try {
            #incluindo disciplina as Disciplinas
            $this->turmaService->removerDisciplina($request->all());

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Remoção realizada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }


//    /**
//     * @param Request $request
//     * @return mixed
//     */
//    public function store(Request $request)
//    {
//        try {
//            #Recuperando os dados da requisição
//            $data = $request->all();
//
//            #Validando a requisição
//            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
//
//            #Executando a ação
//            $this->service->store($data);
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso!']);
//        } catch (ValidatorException $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
//
//    /**
//     * @param $id
//     * @return mixed
//     */
//    public function edit($id)
//    {
//        try {
//            #Recuperando o calendario e declarando variáveis
//            $model      = $this->service->find($id);
//            $calendario = [];
//
//            #Carregando os dados para o cadastro
//            $loadFields = $this->service->load($this->loadFields);
//
//            # Preparando o array de retorno
//            $calendario['data']                = $model->data;
//            $calendario['data_final']          = $model->data_final;
//            $calendario['hora_inicial']        = $model->hora_inicial;
//            $calendario['hora_final']          = $model->hora_final;
//            $calendario['professor_id']        = $model->professor_id;
//            $calendario['id_calendario']       = $model->id;
//            $calendario['sala_id']             = $model->sala_id;
//
//            # Dados de retorno
//            $dados      = compact('calendario', 'loadFields');
//
//            #retorno para view
//            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
//        } catch (\Throwable $e) {dd($e);
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
//
//    /**
//     * @param Request $request
//     * @param $id
//     * @return $this|\Illuminate\Http\RedirectResponse
//     */
//    public function update(Request $request, $id)
//    {
//        try {
//            #Recuperando os dados da requisição
//            $data = $request->all();
//
//            #tratando as rules
//            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);
//
//            #Validando a requisição
//            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
//
//            #Executando a ação
//            $this->service->update($data, $id);
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso!']);
//        } catch (ValidatorException $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
//
//    /**
//     * @param $id
//     * @return mixed
//     */
//    public function delete($id)
//    {
//        try {
//            #Executando a ação
//            $this->service->delete($id);
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Calendário removido com sucesso!']);
//        } catch (ValidatorException $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
//
//    /**
//     * @param $idTurma
//     * @return mixed
//     */
//    public function disciplinasOfCurriculo($idTurma)
//    {
//        try {
//            #Recupernado as Disciplinas
//            $disciplinas = $this->turmaService->getDisciplinasDiferrentOfCurriculo($idTurma);
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'dados' => $disciplinas]);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
}
