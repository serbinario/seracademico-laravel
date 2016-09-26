<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoDisciplinaEletiva extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_alunos_semestres_eletivas';

    protected $fillable = [ 
		'disciplina_id',
		'aluno_semestre_id',
		'turma_id',
		'disciplina_eletiva_id'
	];

}