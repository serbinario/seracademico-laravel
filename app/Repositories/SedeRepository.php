<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SedeRepository
 * @package namespace App\Repositories;
 */
interface SedeRepository extends RepositoryInterface
{
    public function sedes();
}
