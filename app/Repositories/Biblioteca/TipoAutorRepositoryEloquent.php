<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoAutorValidator;
use Seracademico\Repositories\Biblioteca\TipoAutorRepository;
use Seracademico\Entities\Biblioteca\TipoAutor;

/**
 * Class TipoAutorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoAutorRepositoryEloquent extends BaseRepository implements TipoAutorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoAutor::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
