<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
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
        'ativo'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
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
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'fac_curriculo_disciplina', 'curriculo_id', 'disciplina_id');
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
}