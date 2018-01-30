<?php

namespace Seracademico\Repositories\Mestrado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\Mestrado\TurmaValidator;
use Seracademico\Repositories\Mestrado\TurmaRepository;
use Seracademico\Entities\Mestrado\Turma;

/**
 * Class TurmaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TurmaRepositoryEloquent extends BaseRepository implements TurmaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Turma::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAlunosByIdTurma($id)
    {
        $result = \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.aluno_id', '=', 'pos_alunos.id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->groupBy('pos_alunos.id')
            ->where('pos_alunos_turmas.turma_id', $id)
            ->select(['pos_alunos.id'])
            ->get();

        return $result;
    }
}
