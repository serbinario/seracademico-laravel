<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\TipoPermissaoRepository;
use Seracademico\Repositories\SedeRepository;
use Seracademico\Services\UserService;
use Seracademico\Validators\UserValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @var UserValidator
     */
    private $validator;

    /**
     * @var TipoPermissaoRepository
     */
    private $tipoPermissaoRepository;

    /**
     * @var array
     */
    private $loadFields = [
        'Role'
    ];

    /**
     * UserController constructor.
     * @param UserService $service
     * @param UserValidator $validator
     * @param TipoPermissaoRepository $tipoPermissaoRepository
     */
    public function __construct(UserService $service,
                                UserValidator $validator,
                                TipoPermissaoRepository $tipoPermissaoRepository,
                                SedeRepository $sedeRepository)
    {
        $this->service   = $service;
        $this->validator = $validator;
        $this->tipoPermissaoRepository = $tipoPermissaoRepository;
        $this->sedeRepository = $sedeRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $users = \DB::table('users')
            ->join('sedes', 'sedes.id', '=', 'users.sede_id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'sedes.nome as sede'
            ]);

        #Editando a grid
        return Datatables::of($users)->addColumn('action', function ($user) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$user->id.'" title="Editar Usuário"><i class="material-icons">edit</i></a></li>                        
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
        $loadFields['sede'] = $this->sedeRepository->sedes();

        # Recuperando todos os tipos de permissão
        $loadFields['tipopermissao'] = $this->tipoPermissaoRepository->all();

        #Retorno para view
        return view('user.create', compact('loadFields', 'sedes'));
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando o aluno
            $user = $this->service->find($id);

            #Carregando os dados para o cadastro
            //$loadFields['sede'] = $this->sedeRepository->sedes();
            $loadFields = $this->service->load($this->loadFields);

            # Recuperando todos os tipos de permissão
            $loadFields['tipopermissao'] = $this->tipoPermissaoRepository->all();

            #retorno para view
            return view('user.edit', compact('user', 'loadFields'));
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
}
