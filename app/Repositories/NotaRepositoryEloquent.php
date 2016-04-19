<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\NotaValidator;
use Seracademico\Repositories\NotaRepository;
use Seracademico\Entities\Nota;

/**
 * Class NotaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NotaRepositoryEloquent extends BaseRepository implements NotaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Nota::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return NotaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
