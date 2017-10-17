<?php

namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Financeiro\BancoValidator;
use Seracademico\Repositories\Financeiro\BancoRepository;
use Seracademico\Entities\Financeiro\Banco;

/**
 * Class BancoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banco::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
