<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Services\CalendarioService;
use Seracademico\Validators\CalendarioValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class CalendarioController extends Controller
{
    /**
     * @var
     */
    private $service;

    /**
     * @var
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
        'CalendarioDuracao',
        'CalendarioStatus'
    ];

    /**
     * @param CalendarioService $service
     * @param CalendarioValidator $validator
     * @param CalendarioRepository $repository
     */
    public function __construct(CalendarioService $service,
                                CalendarioValidator $validator,
                                CalendarioRepository $repository)
    {
        $this->service     = $service;
        $this->validator   = $validator;
        $this->repository  = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view ('calendario.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('calendario.create', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fac_calendarios_escolares')
                ->select([
                    'id',
                    'nome',
                    'ano'
                ]);
            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/' . $row->id . '" title="Editar Calendário"><i class="material-icons">edit</i></a></li>
                        <li><a class="btn-floating indigo" href="delete/' . $row->id . '" title="Remover Calendário"><i class="material-icons">delete</i></a></li>
                        <li><a title="Adicionar Evento" id="btnModalAdicionarEvento" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus-sign"></i></a></li>
                    </ul>
                    </div>';
            })->make(true);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
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
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
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
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('calendario.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
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
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            # Deletando a matéria
            $this->service->delete($id);

            #retorno para view
            return redirect()->back()->with('message', 'Calendário removido com sucesso!');
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}