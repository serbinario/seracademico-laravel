<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CursoRepository
 * @package namespace App\Repositories;
 */
interface CursoRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function cursos();
}
