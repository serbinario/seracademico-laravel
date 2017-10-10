<?php
namespace Seracademico\Events;

use Seracademico\Entities\Financeiro\Debito;
use Illuminate\Queue\SerializesModels;

class DebitoStored extends Event
{
    use SerializesModels;

    /**
     * @var Debito
     */
    private $debito;

    /**
     * DebitoStored constructor.
     * @param Debito $debito
     */
    public function __construct(Debito $debito)
    {
        $this->debito = $debito;
    }

    /**
     * @return Debito
     */
    public function getDebito()
    {
        return $this->debito;
    }
}
