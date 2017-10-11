<?php
namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Financeiro\FormaPagamentoRepository;
use Seracademico\Services\Financeiro\FormaPagamentoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Financeiro\FormaPagamentoValidator;

class FormaPagamentoController extends Controller
{
    /**
    * @var FormaPagamentoService
    */
    private $service;

    /**
    * @var FormaPagamentoValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [];

    /**
     * @var FormaPagamentoRepository
     */
    private $repository;

    /**
     * @param FormaPagamentoService $service
     * @param FormaPagamentoValidator $validator
     * @param FormaPagamentoRepository $repository
     */
    public function __construct(
        FormaPagamentoService $service,
        FormaPagamentoValidator $validator,
        FormaPagamentoRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('financeiro.formaPagamento.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        try {
            $rows = \DB::table('fin_formas_pagamentos')
                ->select([
                    'fin_formas_pagamentos.id',
                    'fin_formas_pagamentos.nome',
                    'fin_formas_pagamentos.codigo'
                ]);

            return Datatables::of($rows)->addColumn('action', function ($row) {
                $html = "";
                $html .= '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                                <li><a href="edit/'.$row->id.'" class="btn-floating"><i class="material-icons">edit</i></a></li>
                            </ul>
                          </div>';

                return $html;
            })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('financeiro.formaPagamento.create', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $this->service->store($data);

            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $model = $this->repository->find($id);

            $loadFields = $this->service->load($this->loadFields);

            return view('financeiro.formaPagamento.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
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
            $data = $request->all();

            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->service->update($data, $id);

            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $this->service->delete($id);

            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }
}