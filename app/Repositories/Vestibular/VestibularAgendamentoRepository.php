<?php

namespace Seracademico\Repositories\Vestibular;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VestibularAgendamentoRepository
 * @package namespace Seracademico\Repositories;
 */
interface VestibularAgendamentoRepository extends RepositoryInterface
{
    public function buscarDatas();
}
