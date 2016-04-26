<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\TipoPrecoCursoRepository;
use Seracademico\Entities\Graduacao\TipoPrecoCurso;

/**
 * Class TipoPrecoCursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoPrecoCursoRepositoryEloquent extends BaseRepository implements TipoPrecoCursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoPrecoCurso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
