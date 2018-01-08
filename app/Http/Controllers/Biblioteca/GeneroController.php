<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Biblioteca\GeneroService;
use Seracademico\Validators\SalaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;

class GeneroController extends Controller
{
    /**
     * @var GeneroService
     */
    private $service;

    /**
     * @var SalaValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [];

    /**
     * @param GeneroService $service
     * @param SalaValidator $validator
     */
    public function __construct(GeneroService $service, SalaValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.genero.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_genero')->select(['id', 'nome']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating" href="editGenero/'.$row->id.'" title="Editar coleção"><i class="material-icons">edit</i></a></li>                        
                    </ul>
                    </div>';

        })->make(true);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        //$loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('biblioteca.genero.create');
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $result = $this->service->store($data);

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
            #Recuperando a sala
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            //$loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('biblioteca.genero.edit', compact('model'));
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
