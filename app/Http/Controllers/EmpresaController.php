<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\EmpresaService;
use Seracademico\Validators\EmpresaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;

class EmpresaController extends Controller
{
    /**
     * @var EmpresaService
     */
    private $service;

    /**
     * @var EmpresaValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Estado'
    ];

    /**
     * @param EmpresaService $service
     * @param EmpresaValidator $validator
     */
    public function __construct(EmpresaService $service, EmpresaValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Seracademico\Services\Exception
     */
    public function checkRoute()
    {
        try {
            #Retornando uma empresa se existir e false se não existir
            $result = $this->service->isExists();

            #Verificando o se existe empresa
            if ($result) {
                #Se for encontrado uma empresa redirecionará para a edição
                return redirect()->route('seracademico.empresa.edit', ['id' => $result->id]);
            }

            #Se nnão foi encontrado uma empresa redirecionará para o cadastro
            return redirect()->route('seracademico.empresa.create');
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('empresa.create', compact('loadFields'));
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
            $result = $this->service->store($data);

            #Retorno para a view
            return redirect()->route('seracademico.empresa.edit', ['id' => $result->id])->with("message", "Cadastro realizado com sucesso!");
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
            $empresa    = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('empresa.edit', compact('empresa', 'loadFields'));
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
