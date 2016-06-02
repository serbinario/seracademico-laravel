<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EmpresaValidator;
use Seracademico\Repositories\EmpresaRepository;
use Seracademico\Entities\Empresa;

/**
 * Class EmpresaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EmpresaRepositoryEloquent extends BaseRepository implements EmpresaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Empresa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EmpresaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
