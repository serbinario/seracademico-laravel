<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\BoletoRepository;
use Seracademico\Entities\Financeiro\Boleto;

/**
 * Class BoletoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BoletoRepositoryEloquent extends BaseRepository implements BoletoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Boleto::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
