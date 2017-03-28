<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoDisciplinaExtraCurricular extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_alunos_extras';

    protected $fillable = [ 
		'pos_aluno_curso_id',
		'disciplina_id',
		'curriculo_id',
	];

}