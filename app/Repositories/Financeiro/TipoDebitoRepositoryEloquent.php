<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\TipoDebitoRepository;
use Seracademico\Entities\Financeiro\TipoDebito;

/**
 * Class TipoDebitoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoDebitoRepositoryEloquent extends BaseRepository implements TipoDebitoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDebito::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
