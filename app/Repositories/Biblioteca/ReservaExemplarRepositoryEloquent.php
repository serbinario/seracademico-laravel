<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Biblioteca\ReservaExemplarValidator;
use Seracademico\Repositories\Biblioteca\ReservaExemplarRepository;
use Seracademico\Entities\Biblioteca\ReservaExemplar;

/**
 * Class ReservaExemplarRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ReservaExemplarRepositoryEloquent extends BaseRepository implements ReservaExemplarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReservaExemplar::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return ReservaExemplarValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
