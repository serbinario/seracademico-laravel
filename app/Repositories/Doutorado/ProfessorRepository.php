<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProfessorRepository
 * @package namespace App\Repositories;
 */
interface ProfessorRepository extends RepositoryInterface
{
    /**/
    public function getProfessores();
}
