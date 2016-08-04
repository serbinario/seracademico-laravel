<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Financeiro\BeneficioValidator;
use Seracademico\Repositories\Financeiro\BeneficioRepository;
use Seracademico\Entities\Financeiro\Beneficio;

/**
 * Class BeneficioRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BeneficioRepositoryEloquent extends BaseRepository implements BeneficioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Beneficio::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return BeneficioValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
