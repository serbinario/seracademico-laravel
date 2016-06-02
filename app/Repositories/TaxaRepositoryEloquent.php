<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TaxaValidator;
use Seracademico\Repositories\TaxaRepository;
use Seracademico\Entities\Taxa;

/**
 * Class TaxaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TaxaRepositoryEloquent extends BaseRepository implements TaxaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Taxa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TaxaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
