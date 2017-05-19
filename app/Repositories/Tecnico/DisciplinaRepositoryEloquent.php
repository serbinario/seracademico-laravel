<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Tecnico\DisciplinaValidator;
use Seracademico\Repositories\Tecnico\DisciplinaRepository;
use Seracademico\Entities\Tecnico\Disciplina;

/**
 * Class DisciplinaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DisciplinaRepositoryEloquent extends BaseRepository implements DisciplinaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Disciplina::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
