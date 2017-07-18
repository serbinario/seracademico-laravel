<?php

namespace Seracademico\Repositories\Mestrado;

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
