<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\SituacaoValidator;
use Seracademico\Repositories\SituacaoRepository;
use Seracademico\Entities\Situacao;

/**
 * Class SituacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SituacaoRepositoryEloquent extends BaseRepository implements SituacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Situacao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return SituacaoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
