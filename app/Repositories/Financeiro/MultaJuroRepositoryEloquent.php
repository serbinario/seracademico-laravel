<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\MultaJuroRepository;
use Seracademico\Entities\Financeiro\MultaJuro;

/**
 * Class MultaJuroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MultaJuroRepositoryEloquent extends BaseRepository implements MultaJuroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MultaJuro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
