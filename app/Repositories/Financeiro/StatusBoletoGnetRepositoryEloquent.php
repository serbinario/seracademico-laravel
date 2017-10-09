<?php
namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Financeiro\StatusBoletoGnet;

/**
 * Class StatusBoletoGnetRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class StatusBoletoGnetRepositoryEloquent extends BaseRepository implements StatusBoletoGnetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StatusBoletoGnet::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
