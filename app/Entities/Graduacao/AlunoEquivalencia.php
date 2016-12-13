<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoEquivalencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_alunos_semestres_equivalencias';

    protected $fillable = [ 
		'aluno_semestre_id',
		'curriculo_id',
		'disciplina_equivalente_id',
		'disciplina_id',
	];

	public function curriculoEquivalencia()
	{
		return $this->belongsTo(Curriculo::class, 'curriculo_id');
	}

	public function disciplinaEquivalente()
	{
		return $this->belongsTo(Disciplina::class, 'disciplina_equivalente_id');
	}

	public function disciplina()
	{
		return $this->belongsTo(Disciplina::class, 'disciplina_id');
	}
}