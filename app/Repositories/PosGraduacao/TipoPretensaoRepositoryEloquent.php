<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\PosGraduacao\TipoPretensaoRepository;
use Seracademico\Entities\PosGraduacao\TipoPretensao;

/**
 * Class TipoPretensaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoPretensaoRepositoryEloquent extends BaseRepository implements TipoPretensaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoPretensao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
