<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Mestrado\Professor;
use Seracademico\Validators\Mestrado\ProfessorValidator;
use Seracademico\Repositories\Mestrado\ProfessorRepository;

/**
 * Class ProfessorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProfessorRepositoryEloquent extends BaseRepository implements ProfessorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Professor::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
