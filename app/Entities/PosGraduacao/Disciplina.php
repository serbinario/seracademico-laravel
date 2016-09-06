<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Disciplina extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_disciplinas';

    protected $fillable = [
		'nome',
        'codigo',
		'carga_horaria',
		'qtd_falta',
		'tipo_disciplina_id',
		'tipo_nivel_sistema_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function curriculos()
	{
		return $this->belongsToMany(Curriculo::class, "fac_curriculo_disciplina", "disciplina_id", "curriculo_id");
	}

	/**
	 * @return mixed
	 */
	public function turmas()
	{
		return $this->belongsToMany(Turma::class, "fac_turmas_disciplinas", "disciplina_id", "turma_id")
			->withPivot(['id', 'turma_id', 'disciplina_id']);
	}

	/**
	 * @param Model $parent
	 * @param array $attributes
	 * @param string $table
	 * @param bool $exists
	 * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
	 */
	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Turma) {
			return new TurmaDisciplina($parent, $attributes, $table, $exists);
		}

		return parent::newPivot($parent, $attributes, $table, $exists);
	}

}