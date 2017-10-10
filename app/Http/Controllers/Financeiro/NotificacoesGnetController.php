<?php
namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Financeiro\BoletoService;
use Seracademico\Services\Financeiro\GerencianetService;


class NotificacoesGnetController extends Controller
{
    /**
     * @var BoletoService
     */
    private $boletoService;

    /**
     * @var GerencianetService
     */
    private $gerencianetService;

    /**
     * NotificacoesGnetController constructor.
     * @param BoletoService $boletoService
     * @param GerencianetService $gerencianetService
     */
    public function __construct(BoletoService $boletoService, GerencianetService $gerencianetService)
    {
        $this->boletoService = $boletoService;
        $this->gerencianetService = $gerencianetService;
    }


    /**
     * @param Request $request
     * @return array|bool
     */
    public function processarNotificacao(Request $request)
    {
        try {
            $notificacao = $this->gerencianetService->notification($request->get('notification'));
            $this->boletoService->editarStatusPelaNotificacao($notificacao);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'tracing' => $e->getTraceAsString()
            ];
        }
    }
}
