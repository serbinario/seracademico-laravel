<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoNotaVestibular extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'aluno_notas_vestibular';

    protected $fillable = [
        'aluno_id',
        'materia_id',
        'acertos',
        'pontuacao'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
