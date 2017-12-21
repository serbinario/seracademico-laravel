<?php

namespace Seracademico\Repositories\Emais;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Emais\Modalidade;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ModalidadeRepositoryEloquent extends BaseRepository implements ModalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Modalidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
