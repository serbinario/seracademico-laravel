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

	/**
	 * @param $query
	 * @param $value
	 * @return mixed
	 */
	public function scopeCurriculoByAluno($query, $value)
	{
		return $query
			->select(['fac_disciplinas.id', 'fac_disciplinas.nome', 'fac_disciplinas.codigo'])
			->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
			->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
			->join('pos_alunos_cursos', function ($join) use ($value) {
				$join->on(
					'pos_alunos_cursos.id', '=',
					\DB::raw("(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual 
                    where curso_atual.aluno_id = $value and curso_atual.curriculo_id = fac_curriculos.id  ORDER BY curso_atual.id DESC LIMIT 1)")
				);
			});
	}

	/**
	 * @param $query
	 * @param $value
	 * @return mixed
	 */
	public function scopeDisciplinasOfTurma($query, $value)
	{
		return $query
			->select(['fac_disciplinas.id', 'fac_disciplinas.nome', 'fac_disciplinas.codigo'])
			->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
			->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
			->where('fac_turmas.id', $value);
	}
}