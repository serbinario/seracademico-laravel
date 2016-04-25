<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\IlustracaoValidator;
use Seracademico\Repositories\IlustracaoRepository;
use Seracademico\Entities\Ilustracao;

/**
 * Class IlustracaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IlustracaoRepositoryEloquent extends BaseRepository implements IlustracaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ilustracao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return IlustracaoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
