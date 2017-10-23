<?php

namespace Seracademico\Events;

use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DebitoUpdated extends Event
{
    use SerializesModels;

    /**
     * @var Debito
     */
    private $debitoAnterior;

    /**
     * @var Debito
     */
    private $debitoAtual;

    /**
     * Create a new event instance.
     *
     * @param Debito $debitoAnterior
     * @param Debito $debitoAtual
     */
    public function __construct(Debito $debitoAnterior, Debito $debitoAtual)
    {
        $this->debitoAnterior = $debitoAnterior;
        $this->debitoAtual = $debitoAtual;
    }

    /**
     * @return Debito
     */
    public function getDebitoAnterior()
    {
           return $this->debitoAnterior;
    }

    /**
     * @return Debito
     */
    public function getDebitoAtual()
    {
        return $this->debitoAtual;
    }
}
