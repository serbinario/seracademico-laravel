<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\DebitoAbertoAlunoRepository;
use Seracademico\Entities\Financeiro\DebitoAbertoAluno;

/**
 * Class DebitoAbertoAlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DebitoAbertoAlunoRepositoryEloquent extends BaseRepository implements DebitoAbertoAlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DebitoAbertoAluno::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
