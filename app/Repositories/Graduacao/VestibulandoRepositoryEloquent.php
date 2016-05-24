<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Validators\Graduacao\VestibulandoValidator;

/**
 * Class VestibulandoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VestibulandoRepositoryEloquent extends BaseRepository implements VestibulandoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vestibulando::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return VestibulandoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
