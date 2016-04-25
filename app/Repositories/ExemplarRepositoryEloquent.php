<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\ExemplarValidator;
use Seracademico\Repositories\ExemplarRepository;
use Seracademico\Entities\Exemplar;

/**
 * Class ExemplarRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ExemplarRepositoryEloquent extends BaseRepository implements ExemplarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Exemplar::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return ExemplarValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
