<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Doutorado\PlanoEnsinoRepository;
use Seracademico\Entities\Doutorado\PlanoEnsino;

/**
 * Class PlanoEnsinoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlanoEnsinoRepositoryEloquent extends BaseRepository implements PlanoEnsinoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanoEnsino::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
