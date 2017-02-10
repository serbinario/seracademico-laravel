<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Mestrado\Turma;
use Seracademico\Entities\SituacaoAluno;
use Illuminate\Database\Eloquent\Model;

class PivotAlunoCurso extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'pos_alunos_cursos';

    /**
     * @var array
     */
    protected $fillable = [
        'aluno_id',
        'curriculo_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, "pos_alunos_turmas", "pos_aluno_curso_id", "turma_id")
            ->withPivot([
                'id',
                'pos_aluno_curso_id',
                'turma_id'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function situacoes()
    {
        return $this->belongsToMany(SituacaoAluno::class, "pos_alunos_situacoes", "pos_aluno_curso_id", "situacao_id")
            ->withPivot([
                'id',
                'turma_origem_id',
                'turma_destino_id'
            ]);
    }

    /**
     * @param Model $parent
     * @param array $attributes
     * @param string $table
     * @param bool $exists
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Turma) {
            return new AlunoTurma($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}