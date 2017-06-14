<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Tecnico\ModuloRepository;
use Seracademico\Entities\Tecnico\Modulo;

/**
 * Class ModuloRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class ModuloRepositoryEloquent extends BaseRepository implements ModuloRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Modulo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
