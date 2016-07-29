<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\TipoJuroRepository;
use Seracademico\Entities\Financeiro\TipoJuro;

/**
 * Class TipoJuroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoJuroRepositoryEloquent extends BaseRepository implements TipoJuroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoJuro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
