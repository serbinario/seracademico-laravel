<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Http\Requests\ReleaseCreateRequest;
use Seracademico\Http\Requests\ReleaseUpdateRequest;
use Seracademico\Repositories\ReleaseRepository;
use Seracademico\Validators\ReleaseValidator;
use Seracademico\Services\ReleasesService;


class ReleasesController extends Controller
{
    /**
     * @var ReleaseRepository
     */
    protected $repository;

    /**
     * @var ReleaseValidator
     */
    protected $validator;

    /**
     * @var
     */
    protected $service;

    /**
     * @param ReleaseRepository $repository
     * @param ReleaseValidator $validator
     * @param ReleasesService $service
     */
    public function __construct(ReleaseRepository $repository,
                                ReleaseValidator $validator,
                                ReleasesService $service)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->service  = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lancamentos = $this->service->buscarLancamentos();

        return view('release.index', compact('lancamentos'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $desenvolvedor = $this->repository->desenvolvedores();
        $tipoLancamento = $this->repository->tipoLancamento();

        return view('release.create', compact('desenvolvedor', 'tipoLancamento'));
    }

    /**
     * @param ReleaseCreateRequest $request
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
            #Recuperando a empresa
            $model = $this->service->find($id);

            #retorno para view
            return view('releasenote.edit', compact('model', 'loadFields'));
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

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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

    /*public function tableLancamentos()
    {
        try{
            $lancamentos = $this->service->buscarLancamentos();

            #retorno para view
            return view('releasenote.index', compact('model', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }*/
}
