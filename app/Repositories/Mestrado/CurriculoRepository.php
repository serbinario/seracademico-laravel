<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CurriculoRepository
 * @package namespace App\Repositories;
 */
interface CurriculoRepository extends RepositoryInterface
{
    public function getCurriculoAtivo($cursoId);
}
