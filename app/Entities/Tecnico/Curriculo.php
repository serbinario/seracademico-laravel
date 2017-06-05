<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\PivotCurriculoDisciplina;
use Seracademico\Uteis\SerbinarioDateFormat;

class Curriculo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_curriculos';

	protected $dates    = [
		'valido_inicio',
		'valido_fim'
	];

    protected $fillable = [ 
		'nome',
		'codigo',
		'ano',
		'valido_inicio',
		'valido_fim',
		'curso_id',
        'tipo_nivel_sistema_id',
        'ativo',
        'modulo_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'fac_curriculo_disciplina', 'curriculo_id', 'disciplina_id')
            ->withPivot([
                'id',
                'periodo',
                'disciplina_id',
                'carga_horaria_total',
                'carga_horaria_teorica',
                'carga_horaria_pratica',
                'qtd_credito',
                'qtd_faltas',
                'pre_requisito_1_id',
                'pre_requisito_2_id',
                'pre_requisito_3_id',
                'pre_requisito_4_id',
                'pre_requisito_5_id',
                'co_requisito_1_id',
            ]);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class, 'curriculo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'pos_alunos_cursos', 'curriculo_id', 'aluno_id')
            ->withPivot(['id']);
    } 

    /**
     * @return string
     */
    public function getValidoInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_inicio']);
    }

    /**
     * @return string
     */
    public function getValidoFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_fim']);
    }

    /**
     * @return string
     */
    public function setValidoInicioAttribute($value)
    {
        $this->attributes['valido_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return string
     */
    public function setValidoFimAttribute($value)
    {
        $this->attributes['valido_fim'] = SerbinarioDateFormat::toUsa($value);
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
        if ($parent instanceof Disciplina) {
            return new PivotCurriculoDisciplina($parent, $attributes, $table, $exists);
        }

        if ($parent instanceof Aluno) {
            return new PivotAlunoCurso($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeByCurso($query, $value)
    {
        return $query->where('curso_id', $value)->where('ativo', 1)->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLessOfAluno($query, $idAluno)
    {
        return $query
            ->whereNotIn('id', function ($query) use ($idAluno) {
                # Recuperando os cursos
                $cursos = $query->from('pos_alunos_cursos')
                    ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
                    ->where('pos_alunos.id', $idAluno)
                    ->orderBy('pos_alunos_cursos.id', 'DESC')
                    ->select(['pos_alunos_cursos.curriculo_id as id'])->get();

                # Verificando se algum registro foi retornado
                if(count($cursos) > 0) {
                    return $cursos[0];
                }

                # Retorno
                return $cursos;
            })
            ->where('tipo_nivel_sistema_id', 3);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTecnico($query)
    {
        return $query->where('tipo_nivel_sistema_id', 4);
    }
}