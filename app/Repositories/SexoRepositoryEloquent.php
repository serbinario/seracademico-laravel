<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\SexoRepository;
use Seracademico\Entities\Sexo;
use Seracademico\Validators\SexoValidator;;

/**
 * Class SexoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SexoRepositoryEloquent extends BaseRepository implements SexoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sexo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SexoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
