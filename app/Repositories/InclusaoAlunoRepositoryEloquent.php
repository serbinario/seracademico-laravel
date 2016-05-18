<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\InclusaoAluno;

/**
 * Class InclusaoAlunoRepository
 * @package namespace App\Repositories;
 */
class InclusaoAlunoRepositoryEloquent extends BaseRepository implements InclusaoAlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InclusaoAluno::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
