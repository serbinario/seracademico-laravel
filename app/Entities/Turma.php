<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Turma extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_turmas';

    protected $dates    = [
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final'
    ];

    protected $fillable = [ 
		'curriculo_id',
		'turno_id',
		'sigla',
		'valor_turma',
		'valor_disciplina',
		'sala_id',
		'obs_sala',
		'codigo',
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final'
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
    public function getMatriculaFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['matricula_fim']);
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
    public function getAulaFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['aula_final']);
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
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * @return mixed
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, "fac_turmas_disciplinas", "turma_id", "disciplina_id")
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
        if ($parent instanceof Disciplina) {
            return new TurmaDisciplina($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }


}