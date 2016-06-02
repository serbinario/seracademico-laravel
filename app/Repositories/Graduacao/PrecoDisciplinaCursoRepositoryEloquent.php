<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\PrecoDisciplinaCursoRepository;
use Seracademico\Entities\Graduacao\PrecoDisciplinaCurso;

/**
 * Class PrecoDisciplinaCursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PrecoDisciplinaCursoRepositoryEloquent extends BaseRepository implements PrecoDisciplinaCursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PrecoDisciplinaCurso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
