<?php
namespace Seracademico\Http\Controllers\Financeiro;

use Illuminate\Http\Request;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Financeiro\BoletoService;
use Seracademico\Services\Financeiro\GerencianetService;
use Illuminate\Support\Facades\Mail;


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
            $boleto = $this->boletoService->editarStatusPelaNotificacao($notificacao);
            $debito = $boleto->debito;

            if (is_a($debito->debitante, Vestibulando::class)) {
                if ($boleto->statusGnet->codigo == 'paid') {
                    $debitante = $debito->debitante;
                    $debitante->terceiro_passo = true;
                    $debitante->save();

                    $this->sendMail($debitante->id);
                }
            }

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

    /**
     * @param $debitante
     * @return mixed
     * @throws \Exception
     */
    private function sendMail($debitante)
    {
        // pega o vestibulando
        $vestibulando = \DB::table('fac_vestibulandos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_vestibulandos.pessoa_id')
            ->leftJoin('vest_agendamento', 'vest_agendamento.id', '=', 'fac_vestibulandos.agendamento_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_vestibulandos.primeira_opcao_curso_id')
            ->select([
                'fac_vestibulandos.id',
                'pessoas.nome',
                'pessoas.email',
                'pessoas.cpf',
                \DB::raw('DATE_FORMAT(vest_agendamento.data,"%d/%m/%Y") as dataProva'),
                'fac_cursos.nome as primeiraOpcaoCurso'
            ])->where('fac_vestibulandos.id', $debitante)->first();

        $vestibularAtivo = \DB::table('fac_vestibulares')
            ->select(['codigo'])
            ->where('ativo', 1)
            ->first();

        # Verificando a pessoa
        if(!$vestibulando) {
            throw new \Exception('Vestibulando não encontrada');
        }

        # Enviando o email de geração do boleto
        Mail::send('emails.emailConfPagamentoVestibulando', ['vestibulando' => $vestibulando, 'vestibular' => $vestibularAtivo->codigo],
            function ($email) use ($vestibulando) {
                $email->from('enviar@alpha.rec.br', 'Alpha');
                $email->subject('Confirmação de pagamento do vestibular - Faculdade Alpha');
                $email->to($vestibulando->email, 'Alpha Educação e Treinamentos');
            });

        # Retorno
        return $vestibulando;
    }
}
