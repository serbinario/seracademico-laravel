<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\PosGraduacao\CurriculoValidator;
use Seracademico\Repositories\PosGraduacao\CurriculoRepository;
use Seracademico\Entities\PosGraduacao\Curriculo;

/**
 * Class CurriculoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CurriculoRepositoryEloquent extends BaseRepository implements CurriculoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Curriculo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return CurriculoValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $cursoId
     * @return mixed
     */
    public function getCurriculoAtivo($cursoId)
    {
        $rows = \DB::table('fac_curriculos')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->select(['fac_curriculos.id'])
            ->where('fac_cursos.id', '=', $cursoId)
            ->where('fac_curriculos.ativo', '=', 1)->get();

        return $rows;
    }
}
