<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Doutorado\DisciplinaRepository;
use Seracademico\Entities\Doutorado\Disciplina;

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
     * Metodo responsavel por retornar as disciplinas que o professor ministrou dentro do modulo na instituicao
     * Modulo > professor > relatorios avançados (modal)
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
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 5)
            ->where('fac_professores.id', $idProfessor)
            ->get();

        return $disciplinas;
    }
}