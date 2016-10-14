<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\PosGraduacao\AlunoFrequenciaRepository;
use Seracademico\Entities\PosGraduacao\AlunoFrequencia;

/**
 * Class AlunoFrequenciaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoFrequenciaRepositoryEloquent extends BaseRepository implements AlunoFrequenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoFrequencia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
