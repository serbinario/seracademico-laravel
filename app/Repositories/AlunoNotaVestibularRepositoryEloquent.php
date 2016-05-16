<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\AlunoNotaVestibular;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoNotaVestibularRepositoryEloquent extends BaseRepository implements AlunoNotaVestibularRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AlunoNotaVestibular::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
