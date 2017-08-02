<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Doutorado\AlunoDisciplinaDispensadaRepository;
use Seracademico\Entities\Doutorado\AlunoDisciplinaDispensada;

/**
 * Class AlunoDisciplinaDispensadaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoDisciplinaDispensadaRepositoryEloquent extends BaseRepository implements AlunoDisciplinaDispensadaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoDisciplinaDispensada::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
