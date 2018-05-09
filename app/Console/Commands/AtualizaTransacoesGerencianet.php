<?php

namespace Seracademico\Console\Commands;


use Gerencianet\Exception\GerencianetException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\Financeiro\GerencianetService;
use Illuminate\Support\Collection as collect;

class AtualizaTransacoesGerencianet extends Command implements SelfHandling
{

    protected $debitoService;

    protected $debitoRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencianet:detailCharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza transaçoes Gerencianet.';

    public function __construct(
        DebitoService $debitoService,
        DebitoRepository $debitoRepository
    )
    {
        parent::__construct();
        $this->debitoService = $debitoService;
        $this->debitoRepository = $debitoRepository;
    }


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $dataAtual = (new \DateTime())->format('Y-m-d');

       $debitos = Debito::where('data_vencimento','<', $dataAtual)
           //So os boletos aguardando pagamento
           ->where('fin_boletos.gnet_status_id','=', '2')
           //->where('fin_boletos.id','=', '548')
           ->join('fin_boletos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
           ->select('fin_debitos.id')
           ->get();

        foreach($debitos as $debito) {
            $boleto = $debito->boleto;

            echo "\n Debito: ".$debito->id . " Boleto" . $boleto->id;

            $gnet_charge = $boleto->gnet_charge;
            $statusBoleto = $this->getCharge( $gnet_charge);

            if($statusBoleto) {

                //dd($statusBoleto['data']['status']);
                if ($statusBoleto['data']['status'] == "unpaid") {
                    $boleto->gnet_status_id = 4;

                } else if ($statusBoleto['data']['status'] == "paid") {
                    $debito->pago = 1;
                    $boleto->gnet_status_id = 3;
                } else if ($statusBoleto['data']['status'] == "waiting") {
                    $boleto->gnet_status_id = 2;

                } else if ($statusBoleto['data']['status'] == "refunded") {
                    $boleto->gnet_status_id = 5;

                } else if ($statusBoleto['data']['status'] == "contested") {
                    $boleto->gnet_status_id = 6;

                } else if ($statusBoleto['data']['status'] == "canceled") {
                    $boleto->gnet_status_id = 7;

                } else if ($statusBoleto['data']['status'] == "new") {
                    $boleto->gnet_status_id = 1;
                }

                $debito->save();
                $boleto->save();
                //dd($statusBoleto);
            }

        }



    }

    public function getCharge($gnet_charge){
        try{
            return $this->debitoService->detailCharge($gnet_charge);
        }catch(GerencianetException $e){
           return false;
        }



    }

}
