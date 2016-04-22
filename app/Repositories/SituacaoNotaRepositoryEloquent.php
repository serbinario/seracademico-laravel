<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\SituacaoNotaRepository;
use Seracademico\Entities\SituacaoNota;

/**
 * Class SituacaoNotaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SituacaoNotaRepositoryEloquent extends BaseRepository implements SituacaoNotaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SituacaoNota::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
