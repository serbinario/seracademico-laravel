<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\CursoPosGraduacaoRepository;
use Seracademico\Entities\CursoPosGraduacao;
use Seracademico\Validators\CursoPosGraduacaoValidator;

/**
 * Class CursoPosGraduacaoRepositoryRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class CursoPosGraduacaoRepositoryEloquent extends BaseRepository implements CursoPosGraduacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CursoPosGraduacao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
