<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\SedeValidator;
use Seracademico\Repositories\SedeRepository;
use Seracademico\Entities\Sede;

/**
 * Class SedeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SedeRepositoryEloquent extends BaseRepository implements SedeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sede::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return SedeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
