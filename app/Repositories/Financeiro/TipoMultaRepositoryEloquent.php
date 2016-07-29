<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\TipoMultaRepository;
use Seracademico\Entities\Financeiro\TipoMulta;

/**
 * Class TipoMultaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoMultaRepositoryEloquent extends BaseRepository implements TipoMultaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoMulta::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
