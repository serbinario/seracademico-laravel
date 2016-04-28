<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Turma;

class Disciplina extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_disciplinas';

    protected $fillable = [ 
		'nome',
        'codigo',
		'carga_horaria',
		'carga_horaria_pratica',
		'carga_horaria_teorica',
		'qtd_credito',
		'qtd_falta',
		'tipo_disciplina_id',
		'tipo_avaliacao_id',
		'tipo_nivel_sistema_id'
	];

	/**
	 * @param Model $parent
	 * @param array $attributes
	 * @param string $table
	 * @param bool $exists
	 * @return \Illuminate\Database\Eloquent\Relations\Pivot|Curriculo
	 */
	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Curriculo) {
			return new PivotCurriculoDisciplina($parent, $attributes, $table, $exists);
		}

		return parent::newPivot($parent, $attributes, $table, $exists);
	}
}