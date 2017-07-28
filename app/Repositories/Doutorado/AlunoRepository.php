<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AlunoRepository
 * @package namespace App\Repositories;
 */
interface AlunoRepository extends RepositoryInterface
{
    public function obtemDisciplinasDispensadasPelo($id);
}
