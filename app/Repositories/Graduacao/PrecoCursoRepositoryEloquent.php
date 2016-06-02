<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\PrecoCursoRepository;
use Seracademico\Entities\Graduacao\PrecoCurso;

/**
 * Class PrecoCursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PrecoCursoRepositoryEloquent extends BaseRepository implements PrecoCursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PrecoCurso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
