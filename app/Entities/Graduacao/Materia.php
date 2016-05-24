<?php

namespace Seracademico\Entities\Graduacao;

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
                    ->from('fac_vestibular_curso_materia')
                    ->select(['fac_vestibular_curso_materia.materia_id'])
                    ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_materia.vestibular_curso_id')
                    ->where('fac_vestibulares_cursos.id', $value)->get();
            });
    }
}