<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\ParametroValidator;
use Seracademico\Repositories\ParametroRepository;
use Seracademico\Entities\Parametro;

/**
 * Class ParametroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ParametroRepositoryEloquent extends BaseRepository implements ParametroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parametro::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return ParametroValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
