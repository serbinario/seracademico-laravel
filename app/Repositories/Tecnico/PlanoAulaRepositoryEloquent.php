<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Tecnico\PlanoAulaValidator;
use Seracademico\Repositories\Tecnico\PlanoAulaRepository;
use Seracademico\Entities\Tecnico\PlanoAula;

/**
 * Class PlanoAulaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlanoAulaRepositoryEloquent extends BaseRepository implements PlanoAulaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanoAula::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
