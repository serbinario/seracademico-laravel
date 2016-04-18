<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 01/04/16
 * Time: 13:00
 */

namespace Seracademico\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\CalendarioDisciplinaTurmaRepository;
use Seracademico\Entities\CalendarioDisciplinaTurma;
use Seracademico\Validators\CalendarioDisciplinaTurmaValidator;

class CalendarioDisciplinaTurmaEloquent extends BaseRepository implements CalendarioDisciplinaTurmaRepository
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
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return CalendarioDisciplinaTurmaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}