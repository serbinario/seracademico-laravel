<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Biblioteca\EditoraValidator;
use Seracademico\Repositories\Biblioteca\EditoraRepository;
use Seracademico\Entities\Biblioteca\Editora;

/**
 * Class EditoraRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EditoraRepositoryEloquent extends BaseRepository implements EditoraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Editora::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EditoraValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
