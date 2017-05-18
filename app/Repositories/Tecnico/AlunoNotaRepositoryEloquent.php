<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Tecnico\AlunoNotaRepository;
use Seracademico\Entities\Tecnico\AlunoNota;

/**
 * Class AlunoNotaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoNotaRepositoryEloquent extends BaseRepository implements AlunoNotaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoNota::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
