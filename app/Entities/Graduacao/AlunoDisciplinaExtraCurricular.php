<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoDisciplinaExtraCurricular extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_alunos_semestres_disciplinas_extras';

    protected $fillable = [ 
		'disciplina_id',
		'aluno_semestre_id',
		'curriculo_id',
	];

}