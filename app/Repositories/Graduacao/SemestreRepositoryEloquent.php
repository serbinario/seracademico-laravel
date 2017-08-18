<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\SemestreRepository;
use Seracademico\Entities\Graduacao\Semestre;

/**
 * Class SemestreRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SemestreRepositoryEloquent extends BaseRepository implements SemestreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Semestre::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
