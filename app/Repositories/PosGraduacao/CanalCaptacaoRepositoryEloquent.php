<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\PosGraduacao\CanalCaptacaoRepository;
use Seracademico\Entities\PosGraduacao\CanalCaptacao;

/**
 * Class CanalCaptacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CanalCaptacaoRepositoryEloquent extends BaseRepository implements CanalCaptacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CanalCaptacao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
