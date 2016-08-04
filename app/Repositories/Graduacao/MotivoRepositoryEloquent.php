<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\MotivoRepository;
use Seracademico\Entities\Graduacao\Motivo;
use Seracademico\Validators\Graduacao\MotivoValidator;

/**
 * Class MotivoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MotivoRepositoryEloquent extends BaseRepository implements MotivoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Motivo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MotivoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
