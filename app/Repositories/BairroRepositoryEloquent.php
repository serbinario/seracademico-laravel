<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\BairroRepository;
use Seracademico\Entities\Bairro;
use Seracademico\Validators\BairroValidator;;

/**
 * Class BairroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BairroRepositoryEloquent extends BaseRepository implements BairroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bairro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
