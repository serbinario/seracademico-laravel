<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DisciplinaRepository
 * @package namespace App\Repositories;
 */
interface DisciplinaRepository extends RepositoryInterface
{
    /**/
    public function getDisciplinas($idProfessor);
}
