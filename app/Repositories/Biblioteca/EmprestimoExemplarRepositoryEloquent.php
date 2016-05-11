<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Biblioteca\EmprestimoExemplarValidator;
use Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository;
use Seracademico\Entities\Biblioteca\EmprestimoExemplar;

/**
 * Class EmprestimoExemplarRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EmprestimoExemplarRepositoryEloquent extends BaseRepository implements EmprestimoExemplarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmprestimoExemplar::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EmprestimoExemplarValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
