<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\CorRacaRepository;
use Seracademico\Entities\CorRaca;
use Seracademico\Validators\CorRacaValidator;;

/**
 * Class CorRacaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CorRacaRepositoryEloquent extends BaseRepository implements CorRacaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CorRaca::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CorRacaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
