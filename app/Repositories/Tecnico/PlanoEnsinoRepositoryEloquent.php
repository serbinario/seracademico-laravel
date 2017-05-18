<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Tecnico\PlanoEnsinoValidator;
use Seracademico\Repositories\Tecnico\PlanoEnsinoRepository;
use Seracademico\Entities\Tecnico\PlanoEnsino;

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
