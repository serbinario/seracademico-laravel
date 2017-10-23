<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ContaBancariaRepository
 * @package namespace Seracademico\Repositories;
 */
interface ContaBancariaRepository extends RepositoryInterface
{
    public function getContaBancariaPadrao();
}
