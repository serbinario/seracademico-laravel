<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;
use Carbon\Carbon;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'fac_curriculo_disciplina', 'curriculo_id', 'disciplina_id')->withPivot(['id', 'periodo']);
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

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}