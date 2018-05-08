<?php

namespace Seracademico\Console\Commands;


use Gerencianet\Exception\GerencianetException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\Financeiro\GerencianetService;

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
        $dataAtual=(new \DateTime())->format('Y-m-d');
        /*$debito = $this->debitoRepository->findWhere(['data_vencimento','<', $dataAtual],['']);*/

        $debitos = Debito::where('data_vencimento','<', $dataAtual)->get();


        foreach($debitos as $debito) {
            echo "\n Boleto: ".$debito->id;
            $boleto = $debito->boleto;

            $gnet_charge = $boleto->gnet_charge;
            /*$statusBoleto = $this->getCharge( $gnet_charge);*/



            /*if($statusBoleto) {
                dd($boleto->id);
                if ($statusBoleto->status == "unpaid") {
                    $boleto->gnet_status_id = 4;

                } else if ($statusBoleto->status == "paid") {
                    $debito->pago = 1;
                    $boleto->gnet_status_id = 3;
                } else if ($statusBoleto->status == "waiting") {
                    $boleto->gnet_status_id = 2;

                } else if ($statusBoleto->status == "refunded") {
                    $boleto->gnet_status_id = 5;

                } else if ($statusBoleto->status == "contested") {
                    $boleto->gnet_status_id = 6;

                } else if ($statusBoleto->status == "canceled") {
                    $boleto->gnet_status_id = 7;

                } else if ($statusBoleto->status == "new") {
                    $boleto->gnet_status_id = 1;
                }

                $debito->save();
                $boleto->save();
            }*/

        }




       /* //Consulta o boleto
        $statusBoleto = $this->debitoService->detailCharge($gnet_charge);
        dd($statusBoleto);
        $boleto->gnet_status_id = 3;
        $boleto->save();
        dd("ddd");
        $charge = $this->argument('charge');
        dd($this->debitoService->detailCarnet($charge));*/

    }

    public function getCharge($gnet_charge){
        try{
            return $this->debitoService->detailCharge($gnet_charge);
        }catch(GerencianetException $e){
           return false;
        }



    }

}
