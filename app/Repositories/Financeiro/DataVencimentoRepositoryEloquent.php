<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\DataVencimentoValidator;
use Seracademico\Repositories\DataVencimentoRepository;
use Seracademico\Entities\DataVencimento;

/**
 * Class DataVencimentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DataVencimentoRepositoryEloquent extends BaseRepository implements DataVencimentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DataVencimento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return DataVencimentoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
