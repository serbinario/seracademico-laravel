<?php

namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Financeiro\BeneficioService;
use Seracademico\Services\Financeiro\TaxaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Financeiro\BeneficioValidator;

class BeneficioController extends Controller
{
    /**
    * @var BeneficioService
    */
    private $service;

    /**
    * @var BeneficioValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Financeiro\TipoBeneficio'
    ];

    /**
     * BeneficioController constructor.
     * @param BeneficioService $service
     * @param BeneficioValidator $validator
     */
    public function __construct(BeneficioService $service, BeneficioValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('financeiro.beneficio.index');
    }

    /**
     * @return mixed
     */
    public function grid($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fin_beneficios')
            ->join('fin_tipos_beneficios', 'fin_tipos_beneficios.id', '=', 'fin_beneficios.tipo_beneficio_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fin_beneficios.aluno_id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fin_beneficios.id',
                'fin_tipos_beneficios.nome',
                'fin_beneficios.valor',
                'fin_beneficios.data_inicio',
                'fin_beneficios.data_fim'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('taxas' , function ($row) {
                # Recuperando o benefício
                $beneficio = $this->service->find($row->id);

                # Retornando as taxas
                return $beneficio->taxas;
            })
            ->addColumn('action', function ($row) {
                return '<a class="btn-floating indigo" title="Editar" id="btnEditBeneficio"><i class="material-icons">edit</i></a>
                        <a class="btn-floating indigo" title="Excluir" id="btnDestroyBeneficio"><i class="material-icons">delete</i></a>';
        })->make(true);
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
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Cadastro realizado com sucesso']);
        } catch (ValidatorException $e) { 
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessageBag(), 'validator' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
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

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $model]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => $e->getMessage()]);
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
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso!']);
        } catch (ValidatorException $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessageBag(), 'validator' => true]);
        } catch (\Throwable $e) { dd($e->getMessage());
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            #Executando a ação
            $this->service->destroy($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Benefício removido com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->service->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * @return mixed
     */
    public function gridTaxas($idBeneficio)
    {
        #Criando a consulta
        $rows = \DB::table('fin_taxas')
            ->join('fin_beneficios_taxas', 'fin_beneficios_taxas.taxa_id', '=', 'fin_taxas.id')
            ->join('fin_beneficios', 'fin_beneficios.id', '=', 'fin_beneficios_taxas.beneficio_id')
            ->where('fin_beneficios.id', $idBeneficio)
            ->select(['fin_taxas.id', 'fin_taxas.nome', 'fin_taxas.codigo']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Html de retorno
            $html = '<a id="btnDestroyBeneficioEditar" class="btn-floating"><i class="material-icons">delete</i></a>';

            # Retorno
            return $html;
        })->make(true);
    }


    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function attachTaxa(Request $request, $idBeneficio)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('taxas');

            # Recuperando o benefício
            $beneficio = $this->service->find($idBeneficio);

            # Vinculando as taxas ao benefício
            $beneficio->taxas()->attach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Taxa adicionada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function detachTaxa(Request $request, $idBeneficio)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('taxas');

            # Recuperando o benefício
            $beneficio = $this->service->find($idBeneficio);

            # Vinculando as taxas ao benefício
            $beneficio->taxas()->detach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Taxa removida com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getIn(Request $request)
    {
        try {
            // Recuperando os ids das taxas da requisição
            $dados = $request->get('beneficios');

            #Criando a consulta
            $rows = \DB::table('fin_beneficios')
                ->join('fin_tipos_beneficios', 'fin_tipos_beneficios.id', '=', 'fin_beneficios.tipo_beneficio_id')
                ->whereIn('fin_beneficios.id', $dados)
                ->select(['fin_beneficios.id', 'fin_tipos_beneficios.nome', 'fin_beneficios.valor', 'fin_beneficios.codigo']);

            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                # Html de retorno
                $html = '<a id="btnDeleteBeneficio" class="btn-floating"><i class="material-icons">delete</i></a>';

                # Retorno
                return $html;
            })->make(true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}