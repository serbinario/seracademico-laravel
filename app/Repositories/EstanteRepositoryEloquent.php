<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EstanteValidator;
use Seracademico\Repositories\EstanteRepository;
use Seracademico\Entities\Estante;

/**
 * Class EstanteRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EstanteRepositoryEloquent extends BaseRepository implements EstanteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Estante::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EstanteValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
