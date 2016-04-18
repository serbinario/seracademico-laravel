<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ExameRepository;
use Seracademico\Entities\Exame;
use Seracademico\Validators\ExameValidator;;

/**
 * Class ExameRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ExameRepositoryEloquent extends BaseRepository implements ExameRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Exame::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ExameValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
