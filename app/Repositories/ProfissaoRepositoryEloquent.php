<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ProfissaoRepository;
use Seracademico\Entities\Profissao;
use Seracademico\Validators\ProfissaoValidator;;

/**
 * Class ProfissaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProfissaoRepositoryEloquent extends BaseRepository implements ProfissaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Profissao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProfissaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
