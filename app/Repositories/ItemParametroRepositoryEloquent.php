<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ItemParametroRepository;
use Seracademico\Entities\ItemParametro;

/**
 * Class ParametroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ItemParametroRepositoryEloquent extends BaseRepository implements ItemParametroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ItemParametro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
