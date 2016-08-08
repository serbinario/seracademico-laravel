<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\TipoExigenciaRepository;
use Seracademico\Entities\Financeiro\TipoExigencia;

/**
 * Class TipoExigenciaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoExigenciaRepositoryEloquent extends BaseRepository implements TipoExigenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoExigencia::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
