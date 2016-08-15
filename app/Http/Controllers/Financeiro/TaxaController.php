<?php

namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Financeiro\TaxaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Financeiro\TaxaValidator;

class TaxaController extends Controller
{
    /**
    * @var TaxaService
    */
    private $service;

    /**
    * @var TaxaValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Financeiro\Banco',
        'Financeiro\TipoTaxa',
        'Financeiro\TipoDebito',
        'Financeiro\Exigencia',
        'Financeiro\TipoMulta',
        'Financeiro\TipoJuro',
        'Graduacao\\Semestre'
    ];

    /**
    * @param TaxaService $service
    * @param TaxaValidator $validator
    */
    public function __construct(TaxaService $service, TaxaValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('financeiro.taxa.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fin_taxas')->select(['id', 'nome', 'codigo', 'valor', 'dia_vencimento']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Html de retorno
            $html = '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a href="edit/'.$row->id.'" class="btn-floating"><i class="material-icons">edit</i></a></li>
                        </ul>
                     </div>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('financeiro.taxa.create', compact('loadFields'));
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
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('financeiro.taxa.edit', compact('model', 'loadFields'));
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
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

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
     * @param Request $request
     * @return mixed
     */
    public function getTaxas(Request $request)
    {
        try {
            # array de retorno
            $arrayTaxas = [];

            #Recuperando os dados da requisição
            $dados = $request->all();

            #Executando a ação
            $taxas = $this->service->getTaxas($dados);

            # Populando o array de retorno
            $count = 0;
            foreach($taxas as $taxa) {
                $arrayTaxas[$count]['id'] = $taxa->id;
                $arrayTaxas[$count]['nome'] = $taxa->nome;

                # contador
                $count++;
            }

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $arrayTaxas]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTaxa($id)
    {
        try {
            #Executando a ação
            $taxa = $this->service->find($id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $taxa]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTaxasIn(Request $request)
    {
        try {
            // Recuperando os ids das taxas da requisição
            $dados = $request->get('taxas');

            #Criando a consulta
            $rows = \DB::table('fin_taxas')
                ->whereIn('id', $dados)
                ->select(['id', 'nome', 'codigo']);

            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                # Html de retorno
                $html = '<a id="btnDeleteTaxa" class="btn-floating"><i class="material-icons">delete</i></a>';

                # Retorno
                return $html;
            })->make(true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
