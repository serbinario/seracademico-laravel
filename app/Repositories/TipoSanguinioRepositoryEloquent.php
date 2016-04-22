<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\TipoSanguinioRepository;
use Seracademico\Entities\TipoSanguinio;
use Seracademico\Validators\TipoSanguinioValidator;;

/**
 * Class TipoSanguinioRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoSanguinioRepositoryEloquent extends BaseRepository implements TipoSanguinioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoSanguinio::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TipoSanguinioValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
