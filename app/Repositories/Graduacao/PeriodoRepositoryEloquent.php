<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\PeriodoRepository;
use Seracademico\Entities\Graduacao\Periodo;
use Seracademico\Validators\Graduacao\PeriodoValidator;

/**
 * Class PeriodoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PeriodoRepositoryEloquent extends BaseRepository implements PeriodoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Periodo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PeriodoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
