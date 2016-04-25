<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\ResponsavelValidator;
use Seracademico\Repositories\ResponsavelRepository;
use Seracademico\Entities\Responsavel;

/**
 * Class ResponsavelRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ResponsavelRepositoryEloquent extends BaseRepository implements ResponsavelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Responsavel::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return ResponsavelValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
