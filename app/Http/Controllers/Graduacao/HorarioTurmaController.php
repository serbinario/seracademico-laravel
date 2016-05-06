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

class HorarioTurmaController extends Controller
{
    /**
     * @var TurmaService
     */
    private $turmaService;

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
        $rows = \DB::table('fac_horarios')
            ->join('fac_horas', 'fac_horas.id', '=', 'fac_horarios.hora_id')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->where('fac_turmas.id', $idTurma)
            ->groupBy('fac_horas.id')
            ->select([
                'fac_horarios.id',
                'fac_horas.id as hora',
                'fac_turmas.id as idTurma'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('domingo', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 1)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('segunda', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 2)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('terca', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 3)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('quarta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 4)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('quinta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 5)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('sexta', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 6)->get();

                return $result[0]->codigo ?? "";
            })
            ->addColumn('sabado', function ($row) {
                $result = \DB::table('fac_disciplinas')
                    ->select(['fac_disciplinas.codigo'])
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->join('fac_horarios', 'fac_horarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
                    ->where('fac_turmas.id', $row->idTurma)
                    ->where('fac_horarios.dia_id', 7)->get();

                return $result[0]->codigo ?? "";
            })->make(true);
    }


//    /**
//     * @param $idTurmaDisciplina
//     * @return mixed
//     */
//    public function gridCalendario($idTurmaDisciplina)
//    {
//        #Criando a consulta
//        $rows = \DB::table('fac_calendarios')
//            ->join('fac_turmas_disciplinas', 'fac_calendarios.turma_disciplina_id', '=', 'fac_turmas_disciplinas.id')
//            ->leftJoin('fac_professores', 'fac_calendarios.professor_id', '=', 'fac_professores.id')
//            ->leftJoin('fac_salas', 'fac_calendarios.sala_id', '=', 'fac_salas.id')
//            ->select([
//                'fac_calendarios.id',
//                'fac_calendarios.data',
//                'fac_calendarios.data_final',
//                'fac_calendarios.hora_inicial',
//                'fac_calendarios.hora_final',
//                'fac_professores.nome as professor',
//                'fac_salas.nome as sala'
//            ])
//            ->where('fac_turmas_disciplinas.id', '=', $idTurmaDisciplina);
//
//        #Editando a grid
//        return Datatables::of($rows)->addColumn('action', function ($row) {
//
//            return '<a title="Editar Calendário" id="btnEditarCalendario" href="#" class="btn-floating indigo"><i class="material-icons">edit</i></a>
//                    <a title="Remover Calendário" id="btnRemoverCalendario" href="#" class="btn-floating red"><i class="material-icons">delete</i></a>';
//        })->make(true);
//    }

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
//
//    /**
//     * @param Request $request
//     * @return mixed
//     */
//    public function incluirDisciplina(Request $request)
//    {
//        try {
//            #incluindo disciplina as Disciplinas
//            $this->turmaService->incluirDisciplina($request->all());
//
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Inclusão realizada com sucesso!']);
//        } catch (\Throwable $e) {
//            #Retorno para a view
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }


}
