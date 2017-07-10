<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\TipoAcervoValidator;
use Seracademico\Repositories\TipoAcervoRepository;
use Seracademico\Entities\Biblioteca\TipoAcervo;

/**
 * Class TipoAcervoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoAcervoRepositoryEloquent extends BaseRepository implements TipoAcervoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoAcervo::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
