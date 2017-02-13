<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Mestrado\ConteudoProgramaticoRepository;
use Seracademico\Entities\Mestrado\ConteudoProgramatico;

/**
 * Class ConteudoProgramaticoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ConteudoProgramaticoRepositoryEloquent extends BaseRepository implements ConteudoProgramaticoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ConteudoProgramatico::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
