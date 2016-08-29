<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\TipoPermissao;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\TipoPermissaoRepository;
use Seracademico\Services\RoleService;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @var TipoPermissaoRepository
     */
    private $tipoPermissaoRepository;

    /**
     * @var array
     */
    private $loadFields = [];

    /**
     * RoleController constructor.
     * @param RoleService $service
     * @param TipoPermissaoRepository $tipoPermissaoRepository
     */
    public function __construct(RoleService $service, TipoPermissaoRepository $tipoPermissaoRepository)
    {
        $this->service = $service;
        $this->tipoPermissaoRepository = $tipoPermissaoRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('role.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $roles = \DB::table('roles')->select(['id', 'name', 'description']);

        #Editando a grid
        return Datatables::of($roles)->addColumn('action', function ($role) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$role->id.'" title="Editar perfil"><i class="material-icons">edit</i></a></li>                        
                    </ul>
                    </div>';

        })->make(true);
    }

    /**
     * @return mixed
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        # Recuperando todos os tipos de permissão
        $loadFields['tipopermissao'] = $this->tipoPermissaoRepository->all();

        #Retorno para view
        return view('role.create', compact('loadFields'));
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando a role
            $role = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            # Recuperando todos os tipos de permissão
            $loadFields['tipopermissao'] = $this->tipoPermissaoRepository->all();

            #retorno para view
            return view('role.edit', compact('role', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($this->validator->errors())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
