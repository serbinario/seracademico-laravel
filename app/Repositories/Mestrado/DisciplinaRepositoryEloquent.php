<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Mestrado\DisciplinaValidator;
use Seracademico\Repositories\Mestrado\DisciplinaRepository;
use Seracademico\Entities\Mestrado\Disciplina;

/**
 * Class DisciplinaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DisciplinaRepositoryEloquent extends BaseRepository implements DisciplinaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Disciplina::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function getDisciplinas($idProfessor)
    {
        $disciplinas = \DB::table('fac_disciplinas')
            ->join('fac_turmas_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
            ->join('fac_calendarios', 'fac_turmas_disciplinas.id', '=', 'fac_calendarios.turma_disciplina_id')
            ->join('fac_professores', 'fac_professores.id', '=', 'fac_calendarios.professor_id')
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome'
            ])
            ->groupBy('fac_disciplinas.nome')
            ->orderBy('fac_disciplinas.id')
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 3)
            ->where('fac_professores.id', $idProfessor)
            ->get();

        return $disciplinas;
    }
}