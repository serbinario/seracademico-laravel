<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 01/04/16
 * Time: 13:00
 */

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Mestrado\CalendarioDisciplinaTurmaRepository;
use Seracademico\Entities\Mestrado\CalendarioDisciplinaTurma;
use Seracademico\Validators\Mestrado\CalendarioDisciplinaTurmaValidator;

class CalendarioDisciplinaTurmaRepositoryEloquent extends BaseRepository implements CalendarioDisciplinaTurmaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CalendarioDisciplinaTurma::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}