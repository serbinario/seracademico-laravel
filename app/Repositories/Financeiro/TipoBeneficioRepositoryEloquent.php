<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Financeiro\TipoBeneficioValidator;
use Seracademico\Repositories\Financeiro\TipoBeneficioRepository;
use Seracademico\Entities\Financeiro\TipoBeneficio;

/**
 * Class TipoBeneficioRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoBeneficioRepositoryEloquent extends BaseRepository implements TipoBeneficioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoBeneficio::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoBeneficioValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
