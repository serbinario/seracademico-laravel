<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Doutorado\DiarioAulaValidator;
use Seracademico\Repositories\Doutorado\DiarioAulaRepository;
use Seracademico\Entities\Doutorado\DiarioAula;

/**
 * Class DiarioAulaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DiarioAulaRepositoryEloquent extends BaseRepository implements DiarioAulaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DiarioAula::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
         return DiarioAulaValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
