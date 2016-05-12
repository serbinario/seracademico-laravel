<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Turno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_turnos";

    protected $fillable = [
        'nome'
    ];

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeUniqueVestibularCurso($query, $value)
    {
        return $query
            ->select(['fac_turnos.id', 'fac_turnos.nome'])
            ->whereNotIn('fac_turnos.id', function ($query) use($value) {
                return $query
                    ->from('vestibular_curso_turno')
                    ->select(['vestibular_curso_turno.turno_id'])
                    ->join('vestibulares_cursos', 'vestibulares_cursos.id', '=', 'vestibular_curso_turno.vestibular_curso_id')
                    ->where('vestibulares_cursos.id', $value)->get();
            });
    }

}