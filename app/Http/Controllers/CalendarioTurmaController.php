<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\CalendarioDisciplinaTurmaService;
use Seracademico\Validators\CalendarioDisciplinaTurmaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;

class CalendarioTurmaController extends Controller
{
    /**
     * @var CalendarioDisciplinaTurmaService
     */
    private $service;

    /**
     * @var CalendarioDisciplinaTurmaValidator
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
     * @param CalendarioDisciplinaTurmaService $service
     * @param CalendarioDisciplinaTurmaValidator $validator
     */
    public function __construct(CalendarioDisciplinaTurmaService $service, CalendarioDisciplinaTurmaValidator $validator)
    {
        $this->service    = $service;
        $this->validator  = $validator;
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
            ->select(['fac_turmas_disciplinas.id','fac_disciplinas.nome'])
            ->where('fac_turmas.id', '=', $idTurma);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idTurmaDisciplina
     * @return mixed
     */
    public function gridCalendario($idTurmaDisciplina)
    {
        #Criando a consulta
        $rows = \DB::table('fac_calendarios')
            ->join('fac_turmas_disciplinas', 'fac_calendarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
            ->leftJoin('fac_professores', 'fac_calendarios.professor_id', '=', 'fac_professores.id')
            ->leftJoin('fac_salas', 'fac_calendarios.sala_id', '=', 'fac_salas.id')
            ->select([
                'fac_calendarios.id',
                'fac_calendarios.data',
                'fac_calendarios.data_final',
                'fac_calendarios.hora_inicial',
                'fac_calendarios.hora_final',
                'fac_professores.nome as professor',
                'fac_salas.nome as sala'
            ])
            ->where('fac_turmas_disciplinas.id', '=', $idTurmaDisciplina);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a title="Editar Calendário" id="btnEditarCalendario" href="#" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a title="Remover Calendário" id="btnRemoverCalendario" href="#" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
        })->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
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
            return \Illuminate\Support\Facades\Response::json(['sucess' => true,'msg' => 'Cadastro realizado com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['sucess' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['sucess' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $model      = $this->service->find($id);
            $calendario = [];

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            # Preparando o array de retorno
            $calendario['data']                = $model->data;
            $calendario['data_final']          = $model->data_final;
            $calendario['hora_inicial']        = $model->hora_inicial;
            $calendario['hora_final']          = $model->hora_final;
            $calendario['professor_id']        = $model->professor_id;
            $calendario['id_calendario']       = $model->id;

            # Dados de retorno
            $dados      = compact('calendario', 'loadFields');

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['sucess' => true,'msg' => 'Edição realizada com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['sucess' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['sucess' => false,'msg' => $e->getMessage()]);
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
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Calendário removido com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
