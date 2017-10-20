<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro;
use Seracademico\Entities\Financeiro\Extrato;

/**
 * Class ExtratoRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class ExtratoRepositoryEloquent extends BaseRepository implements Financeiro\ExtratoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Extrato::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
