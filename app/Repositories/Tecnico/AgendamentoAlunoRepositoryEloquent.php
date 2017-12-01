<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Tecnico\AgendamentoAluno;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AgendamentoAlunoRepositoryEloquent
    extends BaseRepository implements AgendamentoAlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AgendamentoAluno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
