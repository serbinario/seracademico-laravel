<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoDiaValidator;
use Seracademico\Repositories\TipoDiaRepository;
use Seracademico\Entities\TipoDia;

/**
 * Class TipoDiaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoDiaRepositoryEloquent extends BaseRepository implements TipoDiaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDia::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoDiaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
