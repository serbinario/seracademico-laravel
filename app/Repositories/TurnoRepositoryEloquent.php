<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\TurnoRepository;
use Seracademico\Entities\Turno;

/**
 * Class TurnoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TurnoRepositoryEloquent extends BaseRepository implements TurnoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Turno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
