<?php

namespace Seracademico\Repositories\Emais;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Emais\ModalidadeAluno;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ModalidadeAlunoRepositoryEloquent extends BaseRepository implements ModalidadeAlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModalidadeAluno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
