<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Facades\ParametroBancoFacade;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Graduacao\VestibulandoFinanceiroRepository;
use Seracademico\Services\Financeiro\BoletoVestibulandoService;
use Seracademico\Services\Graduacao\VestibulandoService;
use Seracademico\Validators\Graduacao\VestibulandoValidator;
use Yajra\Datatables\Datatables;
use OpenBoleto\Banco\CaixaSICOB;
use OpenBoleto\Agente;

class VestibulandoFinanceiroController extends Controller
{
    /**
     * @var VestibulandoService
     */
    private $service;

    /**
     * @var BoletoVestibulandoService
     */
    private $boletoVestibulandoService;

    /**
     * @var VestibulandoFinanceiroRepository
     */
    private $vestibulandoFinanceiroRepository;

    /**
     * VestibulandoFinanceiroController constructor.
     * @param VestibulandoService $service
     * @param BoletoVestibulandoService $boletoVestibulandoService
     */
    public function __construct(VestibulandoService $service,
                                BoletoVestibulandoService $boletoVestibulandoService,
                                VestibulandoFinanceiroRepository $vestibulandoFinanceiroRepository)
    {
        $this->service = $service;
        $this->boletoVestibulandoService = $boletoVestibulandoService;
        $this->vestibulandoFinanceiroRepository = $vestibulandoFinanceiroRepository;
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
                'fac_vestibulandos_financeiros.valor_desconto',
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
                //<li><a class="btn-floating" id="btnCloseDebitoAberto" title="Fechar Débito"><i class="material-icons">edit</i></a></li>
                return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating" id="btnEditDebitosAbertos" title="Editar débito"><i class="material-icons">edit</i></a></li>   
                            <li><a class="btn-floating" id="btnRemoveDebitosAbertos" title="Remover débito"><i class="material-icons">delete</i></a></li>
                            <li><a class="btn-floating" id="btnGerarBoleto" title="Gerar Boleto"><i class="material-icons">date_range</i></a></li>
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
                'fac_vestibulandos_financeiros.data_pagamento',
                'fac_vestibulandos_financeiros.valor_pago',
                'fac_vestibulandos_financeiros.valor_desconto',
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
                //<li><a class="btn-floating" id="btnCloseDebitoAberto" title="Fechar Débito"><i class="material-icons">edit</i></a></li>
                return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating" id="btnEditDebitosPagos" title="Editar débito"><i class="material-icons">edit</i></a></li>   
                            <li><a class="btn-floating" id="btnRemoveDebitosPagos" title="Remover débito"><i class="material-icons">delete</i></a></li>
                        </ul>
                        </div>';
            })->make(true);
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
                'pago' => $debito->pago,
                'debito' => $debito
            ];

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $dados]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function closeDebitoAberto($id)
    {
        try {
            #Recuperando o aluno
            $debito = $this->service->findDebito($id);

            # Fechando o débito
            $debito->pago = 1;
            $debito->save();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Fechamento realizado com sucesso!']);
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

    /**
     * @return mixed
     */
    public function gridBoletos($idVestibulando)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fin_boletos_vestibulandos')
                ->join('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.id', '=', 'fin_boletos_vestibulandos.vestibulando_financeiro_id')
                ->join('fac_vestibulandos', 'fac_vestibulandos.id', '=', 'fin_boletos_vestibulandos.vestibulando_id')
                ->join('fin_bancos', 'fin_bancos.id', '=', 'fin_boletos_vestibulandos.banco_id')
                ->where('fac_vestibulandos.id', $idVestibulando)
                ->select([
                    'fin_boletos_vestibulandos.id',
                    'fac_vestibulandos_financeiros.id as idDebito',
                    'fin_bancos.id as idBanco',
                    'fin_boletos_vestibulandos.nosso_numero',
                    'fin_boletos_vestibulandos.vencimento',
                    'fac_vestibulandos_financeiros.valor_debito',
                    'fin_boletos_vestibulandos.data',
                    'fin_boletos_vestibulandos.numero'
                ]);

            #Editando a grid
            return Datatables::of($rows)
                ->addColumn('action', function ($row) {
                    return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating indigo" title="Editar"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating indigo" title="Remover"><i class="material-icons">delete</i></a></li>
                        </ul>
                        </div>';
                })->make(true);
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeBoleto(Request $request)
    {
        try {
            #Recuperando o banco ativo
            $banco     = ParametroBancoFacade::getAtivo();
            $debito    = $this->vestibulandoFinanceiroRepository->find($request->get('idDebito'));
            $objBoleto = null;

            # Verificando se o débito já possui boleto
            if($debito->boleto) {
                $objBoleto = $debito->boleto;
            } else {
                # Data Atual
                $now = new \DateTime('now');

                # Array de boletos
                $boleto = [
                    'vestibulando_financeiro_id' => $debito->id,
                    'banco_id' => $banco->id,
                    'vestibulando_id' => $debito->vestibulando->id,
                    'nosso_numero' => 123455678,
                    'vencimento' => $now,
                    'data' => $now,
                    'numero' => $now->format('YmdHis')
                ];

                # Creando o boleto
                $objBoleto = $this->boletoVestibulandoService->store($boleto);
            }
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $objBoleto]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idBoleto
     * @return string
     * @throws \Exception
     */
    public function gerarBoleto($idBoleto)
    {
        #Recuperando o banco ativo
        $banco   = ParametroBancoFacade::getAtivo();
        $boleto  = $this->boletoVestibulandoService->find($idBoleto);
        $debito  = $boleto->debito;

        $sacado  = new Agente('Fernando Maia', '023.434.234-34', 'ABC 302 Bloco N', '72000-000', 'Brasília', 'DF');
        $cedente = new Agente('Serbinario LTDA', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Brasília', 'DF');

        $objBoleto = new CaixaSICOB(array(
            // Parâmetros obrigatórios
            'dataVencimento' => Carbon::createFromFormat('d/m/Y', $debito->vencimento),
            'valor' => $debito->valor_debito,
            'sequencial' => 1234567, // Para gerar o nosso número
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => 1724, // Até 4 dígitos
            'carteira' => 'SR',
            'conta' => 123456, // Até 8 dígitos
            'convenio' => 1234, // 4, 6 ou 7 dígitos
        ));

        return $objBoleto->getOutput();
    }

    /**
     * @param id $
     * @return mixed
     */
    public function gerarComprovanteInscricao($id)
    {
        try {
            $vestibulando = $this->service->find($id);

            return \PDF::loadView('reports.vestibulandos.comprovanteInscricao', ['vestibulando' =>  $vestibulando])->stream();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}