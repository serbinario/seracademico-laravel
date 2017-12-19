<?php
namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;
use Seracademico\Entities\Tecnico\Aluno;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Repositories\Tecnico\AlunoRepository;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\Tecnico\AlunoService;
use Yajra\Datatables\Datatables;

class AlunoFinanceiroController extends Controller
{
    /**
     * @var DebitoRepository
     */
    private $debitoRepository;

    /**
     * @var DebitoService
     */
    private $debitoService;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var AlunoService
     */
    private $service;


    /**
     * AlunoFinanceiroController constructor.
     * @param DebitoRepository $debitoRepository
     * @param DebitoService $debitoService
     * @param AlunoRepository $alunoRepository
     * @param AlunoService $service
     */
    public function __construct(
        DebitoRepository $debitoRepository,
        DebitoService $debitoService,
        AlunoRepository $alunoRepository,
        AlunoService $service)
    {
        $this->debitoRepository = $debitoRepository;
        $this->debitoService = $debitoService;
        $this->alunoRepository = $alunoRepository;
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->debitoService->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function gridDebitos(Request $request, $id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Aluno::class)
                ->leftJoin('fin_carnes', 'fin_debitos.carne_id', '=', 'fin_carnes.id')
                ->leftJoin('fin_boletos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
                ->leftJoin('fin_status_gnet', 'fin_boletos.gnet_status_id', '=', 'fin_status_gnet.id')
                ->addSelect(\DB::raw("IF(fin_status_gnet.nome!='', fin_status_gnet.nome, 'Não gerado') as situacaoBoleto"))
                ->addSelect('fin_carnes.gnet_carnet_id');

            return DataTables::of($consulta)
                ->addColumn('action', function () {
                    $html = "";
                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .= '       <li><a class="btn-floating" id="btnEditarDebito" title="Editar aluno"><i class="material-icons">edit</i></a></li>';
                    $html .= '       <li><a class="btn-floating" id="btnGerarBoleto" title="Gerar boleto"><i class="material-icons">account_balance_wallet</i></a></li>';
                    $html .= '       <li><a class="btn-floating" id="btnInfoDebito" title="Visualizar informações do débito"><i class="material-icons">search</i></a></li>';
                    $html .= '  </ul>';
                    $html .= '</div>';
                    return $html;
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function gridCarnes(Request $request, $id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Aluno::class)
                ->join('fin_carnes', 'fin_debitos.carne_id', '=', 'fin_carnes.id')
                ->addSelect(\DB::raw('count(fin_debitos.id) as qtd_parcelas'))
                ->addSelect('fin_carnes.gnet_carnet_id')
                ->addSelect('fin_carnes.gnet_link')
                ->addSelect(\DB::raw("DATE_FORMAT(fin_carnes.created_at, '%d/%m/%Y') as data_criacao"))
                ->groupBy('fin_carnes.id', 'fin_taxas.id');

            return DataTables::of($consulta)
                ->addColumn('link', function ($row) {
                    return '<a target="_blank" href="'. $row->gnet_link .'">Visualizar carnê em outra página</a>';
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
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
            $aluno = $this->alunoRepository->find($id);
            $this->debitoService->store($aluno, $request->all());
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDebitoInscricaoByPortal(Request $request)
    {
        try {
            $aluno = $this->alunoRepository->find($request->get('id'));
            $dadosDebito = $this->service->formatDebitoInscricao($aluno, 3);
            $debito = $this->debitoService->store($aluno, $dadosDebito);
            $boleto = $this->debitoService->gerarBoleto($debito->id);

            return response()->json(['status' => 200, 'boleto' => $boleto]);
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine(), 'status' => 500]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBoletoVestibulandoByPortal(Request $request)
    {
        try {
            $aluno = $this->alunoRepository->find($request->get('id'));
            $debito = $aluno->debitos->last();
            $boleto = $debito->boleto;
            $status = $boleto->statusGnet;
            $responseBoleto = array_merge($boleto->toArray(), $status->toArray());

            return response()->json(['status' => 200, 'boleto' => $responseBoleto]);
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage(), 'status' => 500]);
        }
    }
}