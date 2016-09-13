<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\CursoSuperiorRepository;
use Seracademico\Entities\CursoSuperior;

/**
 * Class CursoSuperiorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CursoSuperiorRepositoryEloquent extends BaseRepository implements CursoSuperiorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CursoSuperior::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
