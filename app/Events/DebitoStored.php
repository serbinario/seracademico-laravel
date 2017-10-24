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
     * @var array
     */
    private $dados;

    /**
     * DebitoStored constructor.
     * @param Debito $debito
     */
    public function __construct(Debito $debito, $dados = [])
    {
        $this->debito = $debito;
        $this->dados = $dados;
    }

    /**
     * @return Debito
     */
    public function getDebito()
    {
        return $this->debito;
    }

    /**
     * @return array
     */
    public function getDados()
    {
        return $this->dados;
    }
}
