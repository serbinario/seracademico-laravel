<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CurriculoRepository
 * @package namespace App\Repositories;
 */
interface CurriculoRepository extends RepositoryInterface
{
    public function getCurriculoAtivo($cursoId);
}
