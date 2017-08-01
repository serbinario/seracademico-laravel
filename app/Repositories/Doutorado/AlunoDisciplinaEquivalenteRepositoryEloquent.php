<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Doutorado\AlunoDisciplinaEquivalenteRepository;
use Seracademico\Entities\Doutorado\AlunoDisciplinaEquivalente;

/**
 * Class AlunoDisciplinaEquivalenteRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoDisciplinaEquivalenteRepositoryEloquent extends BaseRepository implements AlunoDisciplinaEquivalenteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoDisciplinaEquivalente::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
