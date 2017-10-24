<?php
namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Repositories\Graduacao\VestibulandoRepository;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\Graduacao\VestibulandoService;
use Yajra\Datatables\Datatables;


class VestibulandoFinanceiroController extends Controller
{
    /**
     * @var VestibulandoService
     */
    private $service;

    /**
     * @var DebitoRepository
     */
    private $debitoRepository;

    /**
     * @var DebitoService
     */
    private $debitoService;

    /**
     * @var VestibulandoRepository
     */
    private $repository;

    /**
     * VestibulandoFinanceiroController constructor.
     * @param DebitoRepository $debitoRepository
     * @param DebitoService $debitoService
     * @param VestibulandoService $service
     * @param VestibulandoRepository $repository
     */
    public function __construct(
        DebitoRepository $debitoRepository,
        DebitoService $debitoService,
        VestibulandoService $service,
        VestibulandoRepository $repository)
    {
        $this->service = $service;
        $this->debitoRepository = $debitoRepository;
        $this->debitoService = $debitoService;
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function gridDebitosAbertos($id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Vestibulando::class)
                ->leftJoin('fin_boletos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
                ->leftJoin('fin_status_gnet', 'fin_boletos.gnet_status_id', '=', 'fin_status_gnet.id')
                ->where('fin_debitos.pago', '!=', 1);

            return DataTables::of($consulta)
                ->addColumn('action', function () {
                    $html = "";
                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .= '       <li><a class="btn-floating" data-debito="aberto" id="btnEditarDebito" title="Editar vestibulando"><i class="material-icons">edit</i></a></li>';
                    $html .= '       <li><a class="btn-floating" id="btnGerarBoleto" title="Gerar boleto"><i class="material-icons">account_balance_wallet</i></a></li>';
                    $html .= '       <li><a class="btn-floating" data-debito="aberto" id="btnInfoDebito" title="Visualizar informações do débito"><i class="material-icons">search</i></a></li>';
                    $html .= '  </ul>';
                    $html .= '</div>';
                    return $html;
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, "Ocorreu um erro");
        }
    }

    /**
     * @return mixed
     */
    public function gridDebitosPagos($id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Vestibulando::class)
                ->leftJoin('fin_boletos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
                ->leftJoin('fin_status_gnet', 'fin_boletos.gnet_status_id', '=', 'fin_status_gnet.id')
                ->where('fin_debitos.pago', 1);

            return DataTables::of($consulta)
                ->addColumn('action', function () {
                    $html = "";
                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .= '       <li><a class="btn-floating" data-debito="pago" id="btnEditarDebito" title="Editar vestibulando"><i class="material-icons">edit</i></a></li>';
                    $html .= '       <li><a class="btn-floating" data-debito="pago" id="btnInfoDebito" title="Visualizar informações do débito"><i class="material-icons">search</i></a></li>';
                    $html .= '  </ul>';
                    $html .= '</div>';
                    return $html;
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, "Ocorreu um erro");
        }
    }

    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDebito($idDebito)
    {
        try {
            $debito = $this->debitoService->find($idDebito);

            return response()->json(['success' => true, 'data' => $debito]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDebito(Request $request, $id)
    {
        try {
            $vestibulando = $this->repository->find($id);
            $this->debitoService->store($vestibulando, $request->all());
            $message = 'Débito cadastrado com sucesso';

            return response()->json(['success' => true, 'msg' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    /**
     * @param Request $request
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDebito(Request $request, $idDebito)
    {
        try {
            $this->debitoService->update($request->all(), $idDebito);
            $message = "Débito atualizado com sucesso";

            return response()->json(['success' => true, 'msg' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function gerarBoleto($idDebito)
    {
        try {
            $boleto = $this->debitoService->gerarBoleto($idDebito);

            return response()->json(['success' => true, 'boleto' => $boleto]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoDebito($idDebito)
    {
        try {
            $debito = $this->debitoService->find($idDebito);

            return response()->json(['success' => true, 'debito' => $debito]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
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
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDebitoInscricaoByPortal(Request $request)
    {
        try {
            $vestibulando = $this->repository->find($request->get('id'));
            $dadosDebito = $this->service->formatDebitoInscricao($vestibulando);
            $debito = $this->debitoService->store($vestibulando, $dadosDebito);
            $boleto = $this->debitoService->gerarBoleto($debito->id);

            return response()->json(['status' => 200, 'boleto' => $boleto->toArray()]);
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage(), 'status' => 500]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBoletoVestibulandoByPortal(Request $request)
    {
        try {
            $vestibulando = $this->repository->find($request->get('id'));
            $debito = $vestibulando->debitos->last();
            $boleto = $debito->boleto;

            return response()->json(['status' => 200, 'boleto' => $boleto->toArray()]);
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage(), 'status' => 500]);
        }
    }
}