<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\TitulacaoRepository;
use Seracademico\Entities\Titulacao;

/**
 * Class TitulacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TitulacaoRepositoryEloquent extends BaseRepository implements TitulacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Titulacao::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
