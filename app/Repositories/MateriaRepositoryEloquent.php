<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\MateriaValidator;
use Seracademico\Repositories\MateriaRepository;
use Seracademico\Entities\Materia;

/**
 * Class MateriaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MateriaRepositoryEloquent extends BaseRepository implements MateriaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Materia::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return MateriaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
