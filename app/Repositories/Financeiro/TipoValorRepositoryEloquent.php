<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoValorValidator;
use Seracademico\Repositories\TipoValorRepository;
use Seracademico\Entities\TipoValor;

/**
 * Class TipoValorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoValorRepositoryEloquent extends BaseRepository implements TipoValorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoValor::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoValorValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
