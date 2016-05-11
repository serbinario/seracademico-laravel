<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Materia;
use Seracademico\Uteis\SerbinarioDateFormat;

class PivotVestibularCurso extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'vestibulares_cursos';

    /**
     * @var array
     */
    protected $fillable = [
        'curso_id',
        'vestibular_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias()
    {
        return $this->belongsToMany(Materia::class, "vestibular_curso_materia", "vestibular_curso_id", "materia_id")
            ->withPivot(['id', 'peso', 'qtd_questoes']);
    }

    /**
     * @return $this
     */
    public function turnos()
    {
        return $this->belongsToMany(Turno::class, "vestibular_curso_turno", "vestibular_curso_id", "turno_id")
            ->withPivot(['id', 'qtd_vagas', 'descricao']);
    }
}