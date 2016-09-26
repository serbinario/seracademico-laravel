<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\AlunoEquivalenciaRepository;
use Seracademico\Entities\Graduacao\AlunoEquivalencia;

/**
 * Class AlunoEquivalenciaRepositoryEloquent
 * @package Seracademico\Repositories\Graduacao;
 */
class AlunoEquivalenciaRepositoryEloquent extends BaseRepository implements AlunoEquivalenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoEquivalencia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
