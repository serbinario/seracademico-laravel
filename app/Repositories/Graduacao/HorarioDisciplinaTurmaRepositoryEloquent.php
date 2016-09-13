<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\HorarioDisciplinaTurmaRepository;
use Seracademico\Entities\Graduacao\HorarioDisciplinaTurma;

/**
 * Class TurmaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class HorarioDisciplinaTurmaRepositoryEloquent extends BaseRepository implements HorarioDisciplinaTurmaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HorarioDisciplinaTurma::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
