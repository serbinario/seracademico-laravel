<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Entities\Calendario;
use Seracademico\Validators\CalendarioValidator;

/**
 * Class CalendarioRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class CalendarioRepositoryEloquent extends BaseRepository implements CalendarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Calendario::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
