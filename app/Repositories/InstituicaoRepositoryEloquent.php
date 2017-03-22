<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\InstituicaoRepository;
use Seracademico\Entities\Instituicao;

/**
 * Class InstituicaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InstituicaoRepositoryEloquent extends BaseRepository implements InstituicaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Instituicao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
