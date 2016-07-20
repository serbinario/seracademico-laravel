<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\TipoPermissaoRepository;
use Seracademico\Entities\TipoPermissao;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoPermissaoRepositoryEloquent extends BaseRepository implements TipoPermissaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoPermissao::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
