<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Mestrado\PlanoEnsinoValidator;
use Seracademico\Repositories\Mestrado\PlanoEnsinoRepository;
use Seracademico\Entities\Mestrado\PlanoEnsino;

/**
 * Class PlanoEnsinoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlanoEnsinoRepositoryEloquent extends BaseRepository implements PlanoEnsinoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanoEnsino::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return PlanoEnsinoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
