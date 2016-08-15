<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\VestibulandoService;
use Seracademico\Validators\Graduacao\VestibulandoValidator;
use Yajra\Datatables\Datatables;

class VestibulandoFinanceiroController extends Controller
{
    /**
     * @var VestibulandoService
     */
    private $service;

    /**
     * @var array
     */
    private $loadFields = [
    ];

    /**
     * VestibulandoFinanceiroController constructor.
     * @param VestibulandoService $service
     */
    public function __construct(VestibulandoService $service)
    {
        $this->service    = $service;
    }


    /**
     * @return mixed
     */
    public function gridDebitosAbertos($idVestibulando)
    {
        #Criando a consulta
        $debitos = \DB::table('fac_vestibulandos_financeiros')
            ->join('fin_taxas', 'fin_taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
            ->join('fac_vestibulandos', 'fac_vestibulandos.id', '=', 'fac_vestibulandos_financeiros.vestibulando_id')
            ->where('fac_vestibulandos_financeiros.pago', '=', 0)
            ->where('fac_vestibulandos.id', '=', $idVestibulando)
            ->select([
                'fac_vestibulandos_financeiros.id',
                'fac_vestibulandos_financeiros.vencimento',
                'fac_vestibulandos_financeiros.valor_debito',
                'fin_taxas.valor',
                'fac_vestibulandos_financeiros.mes_referencia',
                'fac_vestibulandos_financeiros.ano_referencia',
                'fin_taxas.codigo',
                'fin_taxas.nome'
            ]);

        #Editando a grid
        return Datatables::of($debitos)
            ->addColumn('action', function ($debito) {
                // <li><a class="btn-floating" id="btnRemoveDebitosAbertos" title="Remover débito"><i class="material-icons">delete</i></a></li>
                return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating" id="btnEditDebitosAbertos" title="Editar débito"><i class="material-icons">edit</i></a></li>                         
                        </ul>
                        </div>';
            })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridDebitosPagos($idVestibulando)
    {
        #Criando a consulta
        $debitos = \DB::table('fac_vestibulandos_financeiros')
            ->join('fin_taxas', 'fin_taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
            ->join('fac_vestibulandos', 'fac_vestibulandos.id', '=', 'fac_vestibulandos_financeiros.vestibulando_id')
            ->where('fac_vestibulandos_financeiros.pago', '=', 1)
            ->where('fac_vestibulandos.id', '=', $idVestibulando)
            ->select([
                'fac_vestibulandos_financeiros.id',
                'fac_vestibulandos_financeiros.vencimento',
                'fac_vestibulandos_financeiros.valor_debito',
                'fin_taxas.valor',
                'fac_vestibulandos_financeiros.mes_referencia',
                'fac_vestibulandos_financeiros.ano_referencia',
                'fin_taxas.codigo',
                'fin_taxas.nome'
            ]);

        #Editando a grid
        return Datatables::of($debitos)->make(true);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeDebitosAbertos(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->storeDebitosAbertos($data);

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
    public function editDebitosAbertos($id)
    {
        try {
            #Recuperando o aluno
            $debito = $this->service->findDebito($id);
            
            # Preparando o array de retorno
            $dados  = [
                'tipoTaxaId' => $debito->taxa->tipoTaxa->id,
                'tipoTaxaNome' => $debito->taxa->tipoTaxa->nome,
                'valor_desconto' => $debito->valor_desconto,
                'taxaId' => $debito->taxa->id,
                'taxaNome' => $debito->taxa->nome,
                'taxaValor' => $debito->taxa->valor,
                'vencimento' => $debito->vencimento,
                'valor_debito' => $debito->valor_debito ?? $debito->taxa->valor,
                'mes_referencia' => $debito->mes_referencia,
                'ano_referencia' => $debito->ano_referencia,
                'observacao' => $debito->observacao,
                'pago' => $debito->pago
            ];

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $dados]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateDebitosAbertos(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->updateDebitosAbertos($data, $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteDebitosAbertos($id)
    {
        try {
            #Recuperando o aluno
            $this->service->deleteDebitosAbertos($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Débito removido com sucesso!']);
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
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $dados = $this->service->search(key($data), $data[key($data)]);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}