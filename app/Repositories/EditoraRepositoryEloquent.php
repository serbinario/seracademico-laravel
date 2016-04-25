<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EditoraValidator;
use Seracademico\Repositories\EditoraRepository;
use Seracademico\Entities\Editora;

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
