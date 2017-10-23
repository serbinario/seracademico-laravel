<?php
namespace Seracademico\Listeners;

use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Events\DebitoUpdated;
use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Repositories\Financeiro\ExtratoRepository;

class ContaBancariaEditarBalaco
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
     * ContaBancariaEditarBalaco constructor.
     * @param ContaBancariaRepository $repository
     * @param ExtratoRepository $extratoRepository
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
     * @param  DebitoUpdated  $event
     * @return void
     */
    public function handle(DebitoUpdated $event)
    {
        $debitoAnterior = $event->getDebitoAnterior();
        $debitoAtual = $event->getDebitoAtual();
        
        if ($valor = $this->obtemValor($debitoAnterior, $debitoAtual)) {
            $contaBancariaId = $debitoAtual->conta_bancaria_id;
            $contaBancaria = $this->repository->find($contaBancariaId);
            $contaBancaria->balanco += $valor;
            $contaBancaria->save();
            $this->extratoRepository->create([
                'conta_bancaria_id' => $contaBancariaId,
                'debito_id' => $debitoAtual->id,
                'valor' => $contaBancaria->balanco,
                'balanco' => $valor
            ]);
        }
    }

    /**
     * @param Debito $debitoAnterior
     * @param Debito $debitoAtual
     * @return bool|mixed
     */
    private function obtemValor(Debito $debitoAnterior, Debito $debitoAtual)
    {
        if ($debitoAnterior->pago && $debitoAtual->pago) {
            if ($debitoAnterior->valor_debito !== $debitoAtual->valor_debito) {
                return $debitoAtual->valor_debito - $debitoAnterior->valor_debito;
            }
        }

        if ($debitoAtual->pago && !$debitoAnterior->pago) {
            return  $debitoAtual->valor_debito;
        }

        return false;
    }
}
