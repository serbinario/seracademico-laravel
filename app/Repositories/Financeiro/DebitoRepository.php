<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DebitoRepository
 * @package namespace App\Repositories;
 */
interface DebitoRepository extends RepositoryInterface
{
    public function obtemConsultaDebitosPorDebitante($debitanteId, $tipoDebitante);
}
