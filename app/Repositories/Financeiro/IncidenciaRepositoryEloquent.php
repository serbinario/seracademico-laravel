<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\IncidenciaValidator;
use Seracademico\Repositories\IncidenciaRepository;
use Seracademico\Entities\Incidencia;

/**
 * Class IncidenciaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IncidenciaRepositoryEloquent extends BaseRepository implements IncidenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Incidencia::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return IncidenciaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
