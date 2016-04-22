<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\GrauInstrucaoRepository;
use Seracademico\Entities\GrauInstrucao;
use Seracademico\Validators\GrauInstrucaoValidator;;

/**
 * Class GrauInstrucaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GrauInstrucaoRepositoryEloquent extends BaseRepository implements GrauInstrucaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GrauInstrucao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GrauInstrucaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
