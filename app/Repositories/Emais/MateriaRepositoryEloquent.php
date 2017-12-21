<?php

namespace Seracademico\Repositories\Emais;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Emais\Materia;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MateriaRepositoryEloquent extends BaseRepository implements MateriaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Materia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
