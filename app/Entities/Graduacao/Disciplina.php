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

	/**
	 * @param $query
	 * @param $value
	 * @return mixed
	 */
	public function scopeUniqueDisciplina($query, $value)
	{
		return $query
            ->select(['fac_disciplinas.id', 'fac_disciplinas.nome', 'fac_disciplinas.codigo'])
			->whereNotIn('fac_disciplinas.id', function ($query) use ($value) {
                $query->from('fac_curriculo_disciplina')
                    ->select('fac_curriculo_disciplina.disciplina_id')
                    ->join('fac_curriculos', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->where('fac_curriculos.id', $value)->get();
            })
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 1);
	}

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeTipoNivelSistema($query, $value)
    {
        return $query->select('id', 'nome', 'codigo')->where('tipo_nivel_sistema_id', $value);
    }
}