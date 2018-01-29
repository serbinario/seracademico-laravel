<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TurmaRepository
 * @package namespace App\Repositories;
 */
interface TurmaRepository extends RepositoryInterface
{
    public function getAlunosByIdTurma($id);
}
