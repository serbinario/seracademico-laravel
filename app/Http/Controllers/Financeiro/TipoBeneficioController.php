<?php

namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Financeiro\TipoBeneficioService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Financeiro\TipoBeneficioValidator;

class TipoBeneficioController extends Controller
{
    /**
    * @var TipoBeneficioService
    */
    private $service;

    /**
    * @var TipoBeneficioValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Financeiro\TipoValor',
        'Financeiro\Incidencia',
        'Financeiro\DataVencimento',
        'Financeiro\TipoDia',
        'Financeiro\TipoValor'
    ];

    /**
    * @param TipoBeneficioService $service
    * @param TipoBeneficioValidator $validator
    */
    public function __construct(TipoBeneficioService $service, TipoBeneficioValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('financeiro.tipoBeneficio.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fin_tipos_beneficios')
            ->leftJoin('fin_incidencia', 'fin_incidencia.id', '=', 'fin_tipos_beneficios.incidencia_id')
            ->leftJoin('fin_tipo_valores', 'fin_tipo_valores.id', '=', 'fin_tipos_beneficios.tipo_id')
            ->leftJoin('fin_data_vencimento as data_nascimento_inicial ', 'data_nascimento_inicial.id', '=', 'fin_tipos_beneficios.dia_inicial_id')
            ->leftJoin('fin_data_vencimento as data_nascimento_final', 'data_nascimento_final.id', '=', 'fin_tipos_beneficios.dia_final_id')
            ->leftJoin('fin_tipo_dia', 'fin_tipo_dia.id', '=', 'fin_tipos_beneficios.tipo_dia_id')

//            $rows = \DB::table('pessoas')
//                ->join('fac_vestibulandos', 'fac_vestibulandos.id', '=' 'pessoas.vestibulando_id')
//
//                ->select(['pessoas.id', 'pessoas.cpf', ]);

            ->select([
                'fin_tipos_beneficios.id',
                'fin_tipos_beneficios.codigo',
                'fin_tipos_beneficios.nome',
                'fin_tipos_beneficios.valido_inicio as validoInicio',
                'fin_tipos_beneficios.valido_fim as validoFim' ,
                'fin_tipos_beneficios.data_inicio as dataInicio',
                'fin_tipos_beneficios.data_fim as dataFim',
                'fin_tipos_beneficios.valor',
                'fin_tipo_valores.nome as tipoId',
                'fin_incidencia.nome as incidenciaId',
                'data_nascimento_inicial.nome as diaInicialId',
                'data_nascimento_final.nome as diaFinalId',
                'fin_tipo_dia.nome as tipoDiaId'
            ]);

        //where

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Recuperando o tipo de benefício
            $tipoBeneficio = $this->service->find($row->id);

            # Html de retorno
            $html = '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a href="edit/'.$row->id.'" class="btn-floating"><i class="material-icons">edit</i></a></li>';

            # Verificando a possibilidade de remoção
            if(count($tipoBeneficio->beneficios) == 0) {
                $html .= '<li><a href="delete/'.$row->id.'" class="btn-floating"><i class="material-icons">delete</i></a></li>';
            }

            # Html de retorno
            $html .=   '</ul>
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
        return view('financeiro.tipoBeneficio.create', compact('loadFields'));
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

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

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
            return view('financeiro.tipoBeneficio.edit', compact('model', 'loadFields'));
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
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTipoBeneficio($id)
    {
        try {
            #Executando a ação
            $tipoBeneficio = $this->service->find($id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $tipoBeneficio]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
