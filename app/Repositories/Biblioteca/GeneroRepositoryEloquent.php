<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\GeneroValidator;
use Seracademico\Repositories\Biblioteca\GeneroRepository;
use Seracademico\Entities\Biblioteca\Genero;

/**
 * Class GeneroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GeneroRepositoryEloquent extends BaseRepository implements GeneroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Genero::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
