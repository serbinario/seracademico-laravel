<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\DepartamentoValidator;
use Seracademico\Repositories\DepartamentoRepository;
use Seracademico\Entities\Departamento;

/**
 * Class DepartamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DepartamentoRepositoryEloquent extends BaseRepository implements DepartamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Departamento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return DepartamentoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
