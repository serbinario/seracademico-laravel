<?php
namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Financeiro\CarneRepository;
use Seracademico\Entities\Financeiro\Carne;

/**
 * Class CarneRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CarneRepositoryEloquent extends BaseRepository implements CarneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Carne::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
