<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Mestrado\TurmaValidator;
use Seracademico\Repositories\Mestrado\TurmaRepository;
use Seracademico\Entities\Mestrado\Turma;

/**
 * Class TurmaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TurmaRepositoryEloquent extends BaseRepository implements TurmaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Turma::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
         return TurmaValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
