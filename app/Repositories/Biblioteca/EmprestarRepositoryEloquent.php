<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Biblioteca\EmprestarValidator;
use Seracademico\Repositories\Biblioteca\EmprestarRepository;
use Seracademico\Entities\Biblioteca\Emprestar;

/**
 * Class EmprestarRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EmprestarRepositoryEloquent extends BaseRepository implements EmprestarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Emprestar::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EmprestarValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
