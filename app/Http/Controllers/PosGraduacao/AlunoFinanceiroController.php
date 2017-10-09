<?php
namespace Seracademico\Http\Controllers\PosGraduacao;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Seracademico\Entities\PosGraduacao\Aluno;
use Seracademico\Facades\ParametroBancoFacade;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Services\Financeiro\DebitoService;
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
     * AlunoFinanceiroController constructor.
     * @param DebitoRepository $debitoRepository
     * @param DebitoService $debitoService
     * @param AlunoRepository $alunoRepository
     */
    public function __construct(
        DebitoRepository $debitoRepository,
        DebitoService $debitoService,
        AlunoRepository $alunoRepository)
    {
        $this->debitoRepository = $debitoRepository;
        $this->debitoService = $debitoService;
        $this->alunoRepository = $alunoRepository;
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
                ->obtemConsultaDebitosPorDebitante($id,Aluno::class);

            return DataTables::of($consulta)
                ->addColumn('action', function ($debito) {
                    $html  = '<a class="btn-floating" id="btnEditarDebito" title="Editar aluno"><i class="material-icons">edit</i></a>';
                    $html .= '<a class="btn-floating" id="btnGerarBoleto" title="Gerar boleto"><i class="material-icons">account_balance_wallet</i></a>';
                    $html .= '<a class="btn-floating" id="btnVisualizarBoleto" title="Visualizar boleto"><i class="material-icons">search</i></a>';
                    return $html;
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
}