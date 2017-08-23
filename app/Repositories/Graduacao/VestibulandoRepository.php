<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AlunoRepository
 * @package namespace App\Repositories;
 */
interface VestibulandoRepository extends RepositoryInterface
{
    /**
     * @param $idVestibulando
     * @return mixed
     */
    public function dadosVestibulando($idVestibulando);
}
