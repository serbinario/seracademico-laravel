<?php

namespace Seracademico\Http\Controllers\Financeiro;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Seracademico\Facades\ParametroBancoFacade;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Financeiro\BoletoService;
use Seracademico\Services\Financeiro\DebitoAbertoAlunoService;
use Seracademico\Services\Financeiro\FechamentoService;
use Seracademico\Services\Graduacao\AlunoService;
use OpenBoleto\Banco\CaixaSICOB;
use OpenBoleto\Agente;

use Yajra\Datatables\Datatables;

class AlunoFinanceiroController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * @var DebitoAbertoAlunoService
     */
    private $debitoAbertoAlunoService;

    /**
     * @var FechamentoService
     */
    private $fechamentoService;

    /**
     * @var BoletoService
     */
    private $boletoService;

    /**
     * AlunoFinanceiroController constructor.
     * @param AlunoService $service
     * @param DebitoAbertoAlunoService $debitoAbertoAlunoService
     * @param FechamentoService $fechamentoService
     */
    public function __construct(AlunoService $service,
                                DebitoAbertoAlunoService $debitoAbertoAlunoService,
                                FechamentoService $fechamentoService,
                                BoletoService $boletoService)
    {
        $this->service = $service;
        $this->debitoAbertoAlunoService = $debitoAbertoAlunoService;
        $this->fechamentoService = $fechamentoService;
        $this->boletoService = $boletoService;
    }

    /**
     * @return mixed
     */
    public function gridDebitosAbertos(Request $request, $idAluno)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fin_debitos')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fin_debitos.aluno_id')
                ->join('fin_taxas', 'fin_taxas.id', '=', 'fin_debitos.taxa_id')
                ->where('fac_alunos.id', $idAluno)
                ->whereNotExists(function ($query) {
                    $query->select('fin_fechamentos.id')
                        ->from('fin_fechamentos')
                        ->whereRaw('fin_fechamentos.debito_id = fin_debitos.id');
                })
                ->select([
                    'fin_debitos.id',
                    'fin_taxas.id as taxaId',
                    'fin_taxas.codigo',
                    'fin_taxas.nome',
                    'fin_taxas.valor',
                    'fin_debitos.data_vencimento',
                    'fin_taxas.valor_multa',
                    'fin_taxas.valor_juros',
                    'fin_debitos.valor_debito',
                    'fin_debitos.mes_referencia',
                    'fin_debitos.ano_referencia'
                ]);

            #Editando a grid
            return Datatables::of($rows)
                ->addColumn('action', function ($row) {
                    return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>                  
                            <li><a class="btn-floating indigo" title="Editar" id="btnEditDebitoAberto"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating indigo" title="Fechamento" id="btnCreateFechamento"><i class="glyphicon glyphicon-list-alt"></i></a></li>  
                            <li><a class="btn-floating indigo" title="Gerar Boleto"  id="btnGerarBoleto"><i class="material-icons">date_range</i></a></li>                    
                        </ul>
                        </div>';
                })->make(true);
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function gridFechamentos($idAluno)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fin_debitos')
                ->join('fin_fechamentos', 'fin_fechamentos.debito_id', '=', 'fin_debitos.id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fin_debitos.aluno_id')
                ->join('fin_taxas', 'fin_taxas.id', '=', 'fin_debitos.taxa_id')
                ->where('fac_alunos.id', $idAluno)
                ->select([
                    'fin_debitos.id',
                    'fin_taxas.codigo',
                    'fin_taxas.nome',
                    'fin_taxas.valor',
                    'fin_debitos.data_vencimento',
                    'fin_taxas.valor_multa',
                    'fin_taxas.valor_juros',
                    'fin_debitos.valor_debito',
                    'fin_debitos.mes_referencia',
                    'fin_debitos.ano_referencia'
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
     * @return mixed
     */
    public function gridBoletos($idAluno)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fin_boletos')
                ->join('fin_debitos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
                ->join('fac_alunos', 'fac_alunos.id', '=', 'fin_boletos.aluno_id')
                ->join('fin_bancos', 'fin_bancos.id', '=', 'fin_boletos.banco_id')
                ->where('fac_alunos.id', $idAluno)
                ->select([
                    'fin_boletos.id',
                    'fin_debitos.id as idDebito',
                    'fin_bancos.id as idBanco',
                    'fin_boletos.nosso_numero',
                    'fin_boletos.vencimento',
                    'fin_debitos.valor_debito',
                    'fin_boletos.data',
                    'fin_boletos.numero'
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
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeDebitoAberto(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();
           
            #Executando a ação
            $this->debitoAbertoAlunoService->store($data);

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
                'taxaId' => $debito->taxa->id,
                'taxaNome' => $debito->taxa->nome,
                'vencimento' => $debito->vencimento,
                'valor_debito' => $debito->valor_debito,
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
     */
    public function storeBoleto(Request $request)
    {
        try {
            #Recuperando o banco ativo
            $banco   = ParametroBancoFacade::getAtivo();
            $debito  = $this->debitoAbertoAlunoService->find($request->get('idDebito'));

            # Data Atual
            $now = new \DateTime('now');

            # Array de boletos
            $boleto = [
                'debito_id' => $debito->id,
                'banco_id' => $banco->id,
                'aluno_id' => $debito->aluno->id,
                'nosso_numero' => 123455678,
                'vencimento' => Carbon::createFromFormat('d/m/Y', $debito->data_vencimento),
                'data' => $now,
                'numero' => $now->format('YmdHis')
            ];

            # Creando o boleto
            $objBoleto = $this->boletoService->store($boleto);

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
        $boleto  = $this->boletoService->find($idBoleto);
        $debito  = $boleto->debito;

        $sacado  = new Agente('Fernando Maia', '023.434.234-34', 'ABC 302 Bloco N', '72000-000', 'Brasília', 'DF');
        $cedente = new Agente('Serbinario LTDA', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Brasília', 'DF');

        $objBoleto = new CaixaSICOB(array(
            // Parâmetros obrigatórios
            'dataVencimento' => Carbon::createFromFormat('d/m/Y', $debito->data_vencimento),
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
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeFechamento(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->fechamentoService->store($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso']);
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
     * @param $id
     * @return mixed
     */
    public function getDebitoAberto($id)
    {
        try {
            #Executando a ação
            $debito = $this->debitoAbertoAlunoService->find($id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $debito]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}