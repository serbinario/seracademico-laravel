<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Doutorado\CurriculoValidator;
use Seracademico\Repositories\Doutorado\CurriculoRepository;
use Seracademico\Entities\Doutorado\Curriculo;

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
