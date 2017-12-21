<?php

namespace Seracademico\Repositories\Tecnico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Tecnico\AgendamentoSegundaChamada;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AgendamentoSegundaChamadaRepositoryEloquent
    extends BaseRepository implements AgendamentoSegundaChamadaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AgendamentoSegundaChamada::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}