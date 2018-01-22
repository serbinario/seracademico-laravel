<?php

namespace Seracademico\Repositories\HelpDesk;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\HelpDesk\ChamadoRepository;
use Seracademico\Entities\HelpDesk\Chamado;
use Seracademico\Validators\ChamadoValidator;

/**
 * Class ChamadoRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class ChamadoRepositoryEloquent extends BaseRepository implements ChamadoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chamado::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
