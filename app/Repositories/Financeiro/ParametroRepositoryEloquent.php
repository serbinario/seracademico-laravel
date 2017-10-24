<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\ParametroRepository;
use Seracademico\Entities\Financeiro\Parametro;

/**
 * Class BancoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ParametroRepositoryEloquent extends BaseRepository implements ParametroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parametro::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
