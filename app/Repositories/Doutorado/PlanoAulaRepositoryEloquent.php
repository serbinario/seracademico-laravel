<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Doutorado\PlanoAulaValidator;
use Seracademico\Repositories\Doutorado\PlanoAulaRepository;
use Seracademico\Entities\Doutorado\PlanoAula;

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
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return PlanoAulaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
