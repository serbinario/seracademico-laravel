<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoAvaliacaoValidator;
use Seracademico\Repositories\TipoAvaliacaoRepository;
use Seracademico\Entities\TipoAvaliacao;

/**
 * Class TipoAvaliacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoAvaliacaoRepositoryEloquent extends BaseRepository implements TipoAvaliacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoAvaliacao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoAvaliacaoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
