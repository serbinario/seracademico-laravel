<?php

namespace Seracademico\Repositories\Graduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Graduacao\VestibulandoFinanceiro;
use Seracademico\Validators\Graduacao\VestibulandoValidator;

/**
 * Class VestibulandoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VestibulandoFinanceiroRepositoryEloquent extends BaseRepository implements VestibulandoFinanceiroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VestibulandoFinanceiro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
