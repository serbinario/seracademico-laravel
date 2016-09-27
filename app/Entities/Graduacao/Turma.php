<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Turno;
use Seracademico\Uteis\SerbinarioDateFormat;

class Turma extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_turmas';

    protected $dates    = [
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final',
    ];

    protected $fillable = [ 
		'curriculo_id',
		'turno_id',
        'semestre_id',
        'periodo',
		'codigo',
        'descricao',
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final',
        'maximo_vagas',
        'minimo_vagas',
        'tipo_nivel_sistema_id'
	];

    /**
     * @return \DateTime
     */
    public function getMatriculaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['matricula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function setMatriculaInicioAttribute($value)
    {
        $this->attributes['matricula_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getMatriculaFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['matricula_fim']);
    }

    /**
     * @return \DateTime
     */
    public function setMatriculaFimAttribute($value)
    {
        $this->attributes['matricula_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getAulaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['aula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function setAulaInicioAttribute($value)
    {
        $this->attributes['aula_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getAulaFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['aula_final']);
    }

    /**
     * @return \DateTime
     */
    public function setAulaFinalAttribute($value)
    {
        $this->attributes['aula_final'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curriculo()
    {
        return $this->belongsTo(Curriculo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }

    /**
     * @return mixed
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, "fac_turmas_disciplinas", "turma_id", "disciplina_id")
            ->withPivot(['id', 'turma_id', 'disciplina_id', 'plano_ensino_id']);
    }

//
//    /**
//     * @return $this
//     */
//    public function alunos()
//    {
//        return $this->belongsToMany(Aluno::class, "fac_alunos_turmas", "turma_id", "aluno_id")
//            ->withPivot(['id', 'aluno_id', 'disciplina_id']);
//    }

    /**
     * @param Model $parent
     * @param array $attributes
     * @param string $table
     * @param bool $exists
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        # Pivot para disciplina
        if ($parent instanceof Disciplina) {
            return new TurmaDisciplina($parent, $attributes, $table, $exists);
        }

//        # Pivot para Aluno
//        if($parent instanceof Aluno) {
//            return new AlunoTurma($parent, $attributes, $table, $exists);
//        }

        # Retorno do novo pivot
        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}