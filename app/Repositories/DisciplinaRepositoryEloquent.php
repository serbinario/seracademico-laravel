<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\DisciplinaValidator;
use Seracademico\Repositories\DisciplinaRepository;
use Seracademico\Entities\Disciplina;

/**
 * Class DisciplinaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DisciplinaRepositoryEloquent extends BaseRepository implements DisciplinaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Disciplina::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return DisciplinaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
