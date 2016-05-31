<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Turno;
use Seracademico\Uteis\SerbinarioDateFormat;

class PivotVestibularCurso extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'fac_vestibulares_cursos';

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
        return $this->belongsToMany(Materia::class, "fac_vestibular_curso_materia", "vestibular_curso_id", "materia_id")
            ->withPivot(['id', 'peso', 'qtd_questoes']);
    }

    /**
     * @return $this
     */
    public function turnos()
    {
        return $this->belongsToMany(Turno::class, "fac_vestibular_curso_turno", "vestibular_curso_id", "turno_id")
            ->withPivot(['id', 'qtd_vagas', 'descricao']);
    }
}