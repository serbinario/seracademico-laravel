<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Turno;
use Seracademico\Uteis\SerbinarioDateFormat;

class PivotInscritoCurso extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'pos_inscricoes_cursos';

    /**
     * @var array
     */
    protected $fillable = [
        'curso_id',
        'incricao_id'
    ];

    /**
     * @return $this
     */
    public function turnos()
    {
        return $this->belongsToMany(Turno::class, "pos_inscricoes_cursos_turnos", "inscricao_curso_id", "turno_id")
            ->withPivot(['id', 'quantidade']);
    }
}