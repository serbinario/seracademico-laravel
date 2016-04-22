<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\CorredorValidator;
use Seracademico\Repositories\CorredorRepository;
use Seracademico\Entities\Corredor;

/**
 * Class CorredorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CorredorRepositoryEloquent extends BaseRepository implements CorredorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Corredor::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return CorredorValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
