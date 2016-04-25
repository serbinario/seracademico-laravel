<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoAutorValidator;
use Seracademico\Repositories\TipoAutorRepository;
use Seracademico\Entities\TipoAutor;

/**
 * Class TipoAutorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoAutorRepositoryEloquent extends BaseRepository implements TipoAutorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoAutor::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoAutorValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
