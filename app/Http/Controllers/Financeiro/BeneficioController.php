<?php

namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Financeiro\BeneficioService;
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
        $rows = \DB::table('fin_Beneficios')
            ->join('fin_tipos_beneficios', 'fin_tipos_beneficios.id', '=', 'fin_Beneficios.tipo_beneficio_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fin_Beneficios.aluno_id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fin_Beneficios.id',
                'fin_tipos_beneficios.nome',
                'fin_Beneficios.valor',
                'fin_Beneficios.data_inicio',
                'fin_Beneficios.data_fim'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            //<a class="btn-floating indigo" title="Editar" id="btnEditBeneficio"><i class="material-icons">edit</i></a>
            return '<a class="btn-floating indigo" title="Excluir" id="btnDestroyBeneficio"><i class="material-icons">delete</i></a>';
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
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

//    /**
//     * @param $id
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
//     */
//    public function edit($id)
//    {
//        try {
//            #Recuperando a empresa
//            $model = $this->service->find($id);
//
//            #Carregando os dados para o cadastro
//            $loadFields = $this->service->load($this->loadFields);
//
//            #retorno para view
//            return view('financeiro.beneficio.edit', compact('model', 'loadFields'));
//        } catch (\Throwable $e) {
//            return redirect()->back()->with('message', $e->getMessage());
//        }
//    }

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
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso']);
        } catch (\Throwable $e) {
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
}