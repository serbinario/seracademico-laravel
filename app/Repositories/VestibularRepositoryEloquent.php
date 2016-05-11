<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\VestibularValidator;
use Seracademico\Repositories\VestibularRepository;
use Seracademico\Entities\Vestibular;

/**
 * Class VestibularRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VestibularRepositoryEloquent extends BaseRepository implements VestibularRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vestibular::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return VestibularValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
