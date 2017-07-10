<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\IlustracaoValidator;
use Seracademico\Repositories\Biblioteca\IlustracaoRepository;
use Seracademico\Entities\Biblioteca\Ilustracao;

/**
 * Class IlustracaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IlustracaoRepositoryEloquent extends BaseRepository implements IlustracaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ilustracao::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
