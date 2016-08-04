<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\TipoMoedaRepository;
use Seracademico\Entities\Financeiro\TipoMoeda;

/**
 * Class TipoMoedaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoMoedaRepositoryEloquent extends BaseRepository implements TipoMoedaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoMoeda::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
