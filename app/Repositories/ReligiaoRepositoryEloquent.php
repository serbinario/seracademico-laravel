<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ReligiaoRepository;
use Seracademico\Entities\Religiao;
use Seracademico\Validators\ReligiaoValidator;;

/**
 * Class ReligiaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ReligiaoRepositoryEloquent extends BaseRepository implements ReligiaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Religiao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ReligiaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
