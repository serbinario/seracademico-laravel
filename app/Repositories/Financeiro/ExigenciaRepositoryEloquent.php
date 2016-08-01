<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\ExigenciaRepository;
use Seracademico\Entities\Financeiro\Exigencia;

/**
 * Class ExigenciaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ExigenciaRepositoryEloquent extends BaseRepository implements ExigenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Exigencia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
