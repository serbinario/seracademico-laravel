<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\PosGraduacao\CursoValidator;
use Seracademico\Repositories\PosGraduacao\CursoRepository;
use Seracademico\Entities\PosGraduacao\Curso;

/**
 * Class CursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CursoRepositoryEloquent extends BaseRepository implements CursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Curso::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
