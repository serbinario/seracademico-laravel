<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoCursoValidator;
use Seracademico\Repositories\TipoCursoRepository;
use Seracademico\Entities\TipoCurso;

/**
 * Class TipoCursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoCursoRepositoryEloquent extends BaseRepository implements TipoCursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoCurso::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoCursoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
