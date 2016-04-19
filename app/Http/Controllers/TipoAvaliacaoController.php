<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\TipoAvaliacaoService;
use Seracademico\Validators\TipoAvaliacaoValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class TipoAvaliacaoController extends Controller
{
    /**
     * @var TipoAvaliacaoService
     */
    private $service;

    /**
     * @var TipoAvaliacaoValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [];

    /**
     * @param TipoAvaliacaoService $service
     * @param TipoAvaliacaoValidator $validator
     */
    public function __construct(TipoAvaliacaoService $service, TipoAvaliacaoValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tipoAvaliacao.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $tipoAvaliacoes = \DB::table('fac_tipo_avaliacoes')->select(['id', 'nome', 'codigo']);

        #Editando a grid
        return Datatables::of($tipoAvaliacoes)->addColumn('action', function ($tipoAvaliacao) {
            return '<a href="edit/'.$tipoAvaliacao->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';
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
        return view('tipoAvaliacao.create');
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
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
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
            #Recuperando a empresa
            $tipoAvaliacao = $this->service->find($id);

            #Carregando os dados para o cadastro
            //$loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('tipoAvaliacao.edit', compact('tipoAvaliacao'));
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
