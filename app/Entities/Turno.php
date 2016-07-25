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
                    ->from('fac_vestibular_curso_turno')
                    ->select(['fac_vestibular_curso_turno.turno_id'])
                    ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_turno.vestibular_curso_id')
                    ->where('fac_vestibulares_cursos.id', $value)->get();
            });
    }

    /**
     * @param $query
     * @param $vestibular
     * @param $curso
     * @return mixed
     */
    public function scopeUniqueVestibularAndCurso($query, $vestibular, $curso)
    {
        if(is_numeric($curso)) {
            return $query
                ->select(['fac_turnos.id', 'fac_turnos.nome'])
                ->whereNotIn('fac_turnos.id', function ($query) use($vestibular, $curso) {
                    return $query
                        ->from('fac_vestibular_curso_turno')
                        ->select(['fac_vestibular_curso_turno.turno_id'])
                        ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_turno.vestibular_curso_id')
                        ->join('fac_vestibulares', 'fac_vestibulares.id', '=', 'fac_vestibulares_cursos.vestibular_id')
                        ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_vestibulares_cursos.curso_id')
                        ->where('fac_cursos.id', $curso)
                        ->where('fac_vestibulares.id', $vestibular)
                        ->get();
                });
        }
    }
}