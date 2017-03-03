<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class AlunoTurma extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'pos_alunos_turmas';

    /**
     * @var array
     */
    protected $fillable = [
        'turma_id',
        'pos_aluno_curso_id'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notas()
    {
        return $this->hasMany(AlunoNota::class, 'pos_aluno_turma_id');
    }
}