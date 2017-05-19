<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\PeriodoRepository;
use Seracademico\Entities\Periodo;
use Seracademico\Validators\PeriodoValidator;

/**
 * Class PeriodoRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class PeriodoRepositoryEloquent extends BaseRepository implements PeriodoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Periodo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
