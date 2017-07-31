<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Doutorado\Aluno;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoRepositoryEloquent extends BaseRepository implements AlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Aluno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function obtemDisciplinasDispensadasPelo($id)
    {
        // TODO: Implement obtemDisciplinasDispensadasPelo() method.
    }
}
