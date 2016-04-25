<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\AquisicaoValidator;
use Seracademico\Repositories\AquisicaoRepository;
use Seracademico\Entities\Aquisicao;

/**
 * Class AquisicaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AquisicaoRepositoryEloquent extends BaseRepository implements AquisicaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Aquisicao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return AquisicaoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
