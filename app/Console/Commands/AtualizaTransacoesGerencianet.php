<?php

namespace Seracademico\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
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
    protected $signature = 'gerencianet:detailCharge {charge : Charge id}';

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

        $debito = $this->debitoRepository->find(1055);
        $boleto = $debito->boleto;

        //retorna o codigo do boleto
        $gnet_charge = $boleto->gnet_charge;

        //Consulta o boleto
        $statusBoleto = $this->debitoService->detailCharge($gnet_charge);
dd($statusBoleto);
        $boleto->gnet_status_id = 3;
        $boleto->save();
        dd("ddd");
        $charge = $this->argument('charge');
        dd($this->debitoService->detailCarnet($charge));

    }

}
