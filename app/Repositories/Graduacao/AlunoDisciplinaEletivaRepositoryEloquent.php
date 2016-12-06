<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\AlunoDisciplinaEletivaRepository;
use Seracademico\Entities\Graduacao\AlunoDisciplinaEletiva;

/**
 * Class AlunoDisciplinaExtraCurricularRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoDisciplinaEletivaRepositoryEloquent extends BaseRepository implements AlunoDisciplinaEletivaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoDisciplinaEletiva::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
