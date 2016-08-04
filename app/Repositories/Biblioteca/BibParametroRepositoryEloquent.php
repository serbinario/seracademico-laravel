<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Biblioteca\BibParametroValidator;
use Seracademico\Repositories\Biblioteca\BibParametroRepository;
use Seracademico\Entities\Biblioteca\BibParametro;

/**
 * Class BibParametroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BibParametroRepositoryEloquent extends BaseRepository implements BibParametroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BibParametro::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return BibParametroValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
