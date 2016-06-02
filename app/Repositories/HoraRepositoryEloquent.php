<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\HoraRepository;
use Seracademico\Entities\Hora;
use Seracademico\Validators\HoraValidator;

/**
 * Class HoraRepositoryEloquent
 * @package namespace App\Repositories;
 */
class HoraRepositoryEloquent extends BaseRepository implements HoraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Hora::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return HoraValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
