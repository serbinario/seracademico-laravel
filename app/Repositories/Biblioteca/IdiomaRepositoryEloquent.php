<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\IdiomaValidator;
use Seracademico\Repositories\Biblioteca\IdiomaRepository;
use Seracademico\Entities\Biblioteca\Idioma;

/**
 * Class IdiomaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IdiomaRepositoryEloquent extends BaseRepository implements IdiomaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Idioma::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return IdiomaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
