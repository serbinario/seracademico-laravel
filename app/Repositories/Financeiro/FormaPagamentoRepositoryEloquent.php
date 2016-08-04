<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\FormaPagamentoRepository;
use Seracademico\Entities\Financeiro\FormaPagamento;

/**
 * Class FormaPagamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FormaPagamentoRepositoryEloquent extends BaseRepository implements FormaPagamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormaPagamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
