<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Tecnico\InscricaoRepository;
use Seracademico\Entities\Tecnico\Inscricao;

/**
 * Class VestibularRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InscricaoRepositoryEloquent extends BaseRepository implements InscricaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Inscricao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
