<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\PosGraduacao\AlunoDisciplinaDispensadaRepository;
use Seracademico\Entities\PosGraduacao\AlunoDisciplinaDispensada;

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
