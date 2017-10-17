<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Financeiro\TaxaValidator;
use Seracademico\Repositories\Financeiro\TaxaRepository;
use Seracademico\Entities\Financeiro\Taxa;

/**
 * Class TaxaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TaxaRepositoryEloquent extends BaseRepository implements TaxaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Taxa::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
