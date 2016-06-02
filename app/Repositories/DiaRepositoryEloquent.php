<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\DiaRepository;
use Seracademico\Entities\Dia;
use Seracademico\Validators\DiaValidator;

/**
 * Class DiaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DiaRepositoryEloquent extends BaseRepository implements DiaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Dia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
