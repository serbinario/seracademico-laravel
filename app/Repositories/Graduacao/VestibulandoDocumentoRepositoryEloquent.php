<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\VestibulandoDocumentoRepository;
use Seracademico\Entities\Graduacao\VestibulandoDocumento;

/**
 * Class VestibulandoDocumentoRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class VestibulandoDocumentoRepositoryEloquent extends BaseRepository implements VestibulandoDocumentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VestibulandoDocumento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
