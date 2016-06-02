<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoVencimentoValidator;
use Seracademico\Repositories\TipoVencimentoRepository;
use Seracademico\Entities\TipoVencimento;

/**
 * Class TipoVencimentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoVencimentoRepositoryEloquent extends BaseRepository implements TipoVencimentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoVencimento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return TipoVencimentoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
