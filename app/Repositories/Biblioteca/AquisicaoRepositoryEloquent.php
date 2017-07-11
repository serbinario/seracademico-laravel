<?php

namespace Seracademico\Repositories\Biblioteca;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\AquisicaoValidator;
use Seracademico\Repositories\Biblioteca\AquisicaoRepository;
use Seracademico\Entities\Biblioteca\Aquisicao;

/**
 * Class AquisicaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AquisicaoRepositoryEloquent extends BaseRepository implements AquisicaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Aquisicao::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
