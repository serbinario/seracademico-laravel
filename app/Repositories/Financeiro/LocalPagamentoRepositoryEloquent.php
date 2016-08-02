<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\LocalPagamentoRepository;
use Seracademico\Entities\Financeiro\LocalPagamento;

/**
 * Class LocalPagamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LocalPagamentoRepositoryEloquent extends BaseRepository implements LocalPagamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LocalPagamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
