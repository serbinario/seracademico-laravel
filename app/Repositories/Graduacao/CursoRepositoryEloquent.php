<?php

namespace Seracademico\Repositories\Graduacao;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Graduacao\CursoRepository;
use Seracademico\Entities\Graduacao\Curso;

/**
 * Class CursoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CursoRepositoryEloquent extends BaseRepository implements CursoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Curso::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return array
     */
    public function cursos()
    {
        $cursos = [

        ];

        $query = \DB::table('fac_cursos')
            ->select([
                'id',
                'nome'])
            ->where('tipo_nivel_sistema_id', 1)
            ->get();

        foreach($query as $curso) {
            $cursos[$curso->id] = $curso->nome;
        }

        return $cursos;
    }
}
