<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoDisciplinaValidator;
use Seracademico\Repositories\TipoDisciplinaRepository;
use Seracademico\Entities\TipoDisciplina;

/**
 * Class TipoDisciplinaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoDisciplinaRepositoryEloquent extends BaseRepository implements TipoDisciplinaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDisciplina::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoDisciplinaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
