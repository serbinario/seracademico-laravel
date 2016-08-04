<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Financeiro\FechamentoValidator;
use Seracademico\Repositories\Financeiro\FechamentoRepository;
use Seracademico\Entities\Financeiro\Fechamento;

/**
 * Class FechamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FechamentoRepositoryEloquent extends BaseRepository implements FechamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fechamento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
         return FechamentoValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
