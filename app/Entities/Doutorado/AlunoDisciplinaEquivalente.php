<?php

namespace Seracademico\Entities\Doutorado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoDisciplinaEquivalente extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_alunos_equivalencias';

    protected $fillable = [ 
		'pos_aluno_curso_id',
		'disciplina_id',
		'disciplina_equivalente_id',
		'curriculo_id',
	];

}