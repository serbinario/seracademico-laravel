<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Financeiro\BoletoVestibulando;

/**
 * Class BoletoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BoletoVestibulandoRepositoryEloquent extends BaseRepository implements BoletoVestibulandoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BoletoVestibulando::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
