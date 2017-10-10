<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Financeiro\ContaBancaria;

/**
 * Class ContaBancariaRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class ContaBancariaRepositoryEloquent extends BaseRepository implements ContaBancariaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContaBancaria::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
