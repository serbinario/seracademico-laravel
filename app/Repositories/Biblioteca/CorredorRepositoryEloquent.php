<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\CorredorValidator;
use Seracademico\Repositories\Biblioteca\CorredorRepository;
use Seracademico\Entities\Biblioteca\Corredor;

/**
 * Class CorredorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CorredorRepositoryEloquent extends BaseRepository implements CorredorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Corredor::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
