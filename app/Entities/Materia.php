<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Materia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_materias';

    protected $fillable = [ 
		'nome',
		'anotacao',
        'codigo'
	];

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeUniqueVestibularCurso($query, $value)
    {
        return $query
            ->select(['fac_materias.id', 'fac_materias.nome'])
            ->whereNotIn('fac_materias.id', function ($query) use($value) {
                return $query
                    ->from('vestibular_curso_materia')
                    ->select(['vestibular_curso_materia.materia_id'])
                    ->join('vestibulares_cursos', 'vestibulares_cursos.id', '=', 'vestibular_curso_materia.vestibular_curso_id')
                    ->where('vestibulares_cursos.id', $value)->get();
            });
    }
}