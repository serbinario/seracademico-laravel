<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Tecnico\DiarioAulaValidator;
use Seracademico\Repositories\Tecnico\DiarioAulaRepository;
use Seracademico\Entities\Tecnico\DiarioAula;

/**
 * Class DiarioAulaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DiarioAulaRepositoryEloquent extends BaseRepository implements DiarioAulaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DiarioAula::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
