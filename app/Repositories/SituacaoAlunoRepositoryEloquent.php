<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\SituacaoAlunoRepository;
use Seracademico\Entities\SituacaoAluno;

/**
 * Class SituacaoAlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SituacaoAlunoRepositoryEloquent extends BaseRepository implements SituacaoAlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SituacaoAluno::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
