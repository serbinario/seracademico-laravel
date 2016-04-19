<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\TipoNivelSistemaRepository;
use Seracademico\Entities\TipoNivelSistema;

/**
 * Class TipoNivelSistemaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoNivelSistemaRepositoryEloquent extends BaseRepository implements TipoNivelSistemaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoNivelSistema::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
