<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoTaxaValidator;
use Seracademico\Repositories\TipoTaxaRepository;
use Seracademico\Entities\TipoTaxa;

/**
 * Class TipoTaxaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoTaxaRepositoryEloquent extends BaseRepository implements TipoTaxaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoTaxa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoTaxaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
