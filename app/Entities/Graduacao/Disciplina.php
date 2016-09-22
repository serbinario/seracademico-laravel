<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Turma;

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
	 * @return $this
	 */
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, "fac_turmas_disciplinas", "disciplina_id", "turma_id")
            ->withPivot(['id', 'turma_id', 'disciplina_id', 'plano_ensino_id']);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function planosEnsinos()
	{
		return $this->hasMany(PlanoEnsino::class, 'disciplina_id');
	}

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

        if($parent instanceof Turma) {
            return new TurmaDisciplina($parent, $attributes, $table, $exists);
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
	 * @param $idTurma
	 * @param $periodo
	 * @return mixed
	 */
	public function scopeUniqueDisciplinaTurma($query, $idTurma, $periodo)
	{
		return $query
			->select(['fac_disciplinas.id', 'fac_disciplinas.nome', 'fac_disciplinas.codigo'])
			->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
			->join('fac_curriculos', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
			->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
			->where('fac_turmas.id', $idTurma)
			->where('fac_curriculo_disciplina.periodo', $periodo)
			->where('fac_disciplinas.tipo_nivel_sistema_id', 1)
			->whereNotIn('fac_disciplinas.id', function ($query) use ($idTurma) {
				$query->from('fac_turmas_disciplinas')
					->select('fac_turmas_disciplinas.disciplina_id')
					->where('turma_id', $idTurma)->get();
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

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeTipoNivelSistema($query, $value)
    {
        return $query->select('id', 'nome', 'codigo')->where('tipo_nivel_sistema_id', $value);
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
			->join('fac_alunos_cursos', function ($join) use ($value) {
				$join->on(
					'fac_alunos_cursos.id', '=',
					\DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                    where curso_atual.aluno_id = $value and curso_atual.curriculo_id = fac_curriculos.id  ORDER BY curso_atual.id DESC LIMIT 1)")
				);
			});
	}

	/**
	 * @param $query
	 * @param $id
	 * @return mixed
	 */
	public function scopeGetId($query, $id)
	{
		return $query->where('id', $id);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeEletiva($query, $idAluno)
	{
		return $query
			->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
			->where('fac_turmas_disciplinas.eletiva', 1)
            ->whereNotIn('fac_disciplinas.id', function ($where) use ($idAluno) {
                $where->from('fac_curriculo_disciplina')
                    ->select('fac_curriculo_disciplina.disciplina_id')
                    ->join('fac_curriculos', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                        $join->on(
                            'fac_alunos_cursos.id', '=',
                            \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual
                            where curso_atual.aluno_id = $idAluno and curso_atual.curriculo_id = fac_curriculos.id  ORDER BY curso_atual.id DESC LIMIT 1)")
                        );
                    });
            })
			->select([
				'fac_turmas_disciplinas.id',
				'fac_disciplinas.nome',
				'fac_disciplinas.codigo'
			]);
	}
}