<?php

namespace Seracademico\Listeners;

use Seracademico\Events\DebitoStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Repositories\Financeiro\ExtratoRepository;

class ContaBancariaAdicionarBalanco
{
    /**
     * @var ContaBancariaRepository
     */
    private $repository;

    /**
     * @var ExtratoRepository
     */
    private $extratoRepository;

    /**
     * ContaBancariaAdicionarBalanco constructor.
     * @param ContaBancariaRepository $repository
     */
    public function __construct(
        ContaBancariaRepository $repository,
        ExtratoRepository $extratoRepository)
    {
        $this->repository = $repository;
        $this->extratoRepository = $extratoRepository;
    }

    /**
     * Handle the event.
     *
     * @param  DebitoStored  $event
     * @return void
     */
    public function handle(DebitoStored $event)
    {
        $debito = $event->getDebito();

        if ($debito->pago) {
            $contaBandariaId = $debito->conta_bancaria_id;
            $contaBancaria = $this->repository->find($contaBandariaId);
            $contaBancaria->balanco += $debito->valor_debito;
            $contaBancaria->save();
            $this->extratoRepository->create([
                'conta_bancaria_id' => $contaBandariaId,
                'debito_id' => $debito->id,
                'balanco' => $debito->valor_debito,
                'valor' => $contaBancaria->balanco
            ]);
        }
    }
}
