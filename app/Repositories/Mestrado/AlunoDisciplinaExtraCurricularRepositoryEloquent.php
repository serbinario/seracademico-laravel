<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Mestrado\AlunoDisciplinaExtraCurricularRepository;
use Seracademico\Entities\Mestrado\AlunoDisciplinaExtraCurricular;

/**
 * Class AlunoDisciplinaExtraCurricularRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoDisciplinaExtraCurricularRepositoryEloquent extends BaseRepository implements AlunoDisciplinaExtraCurricularRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoDisciplinaExtraCurricular::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
