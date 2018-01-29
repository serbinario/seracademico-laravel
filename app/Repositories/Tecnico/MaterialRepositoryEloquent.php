<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Tecnico\Material;
use Seracademico\Repositories\Tecnico\MaterialRepository;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MaterialRepositoryEloquent
    extends BaseRepository implements MaterialRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Material::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
