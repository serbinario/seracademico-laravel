<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ReleaseRepository
 * @package namespace Seracademico\Repositories;
 */
interface ReleaseRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function desenvolvedores();

    /**
     * @return mixed
     */
    public function tipoLancamento();
}
