<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Financeiro\Taxa;
use Seracademico\Uteis\SerbinarioDateFormat;

class Inscricao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_incricoes';

	protected $dates    = [
        'data_inicio',
        'data_fim',
    ];

    protected $fillable = [
		'codigo',
		'nome',
		'data_inicio',
		'data_fim',
		'quantidade',
		'tipo_nivel_sistema_id',
        'taxa_id',
        'ativo'
	];

    /**
     * @return string
     */
    public function getDataInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inicio']);
    }

    /**
     * @return string
     */
    public function setDataInicioAttribute($value)
    {
        return $this->attributes['data_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return string
     */
    public function getDataFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_fim']);
    }

    /**
     * @return string
     */
    public function setDataFimAttribute($value)
    {
        $this->attributes['data_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'pos_inscricoes_cursos', 'incricao_id', 'curso_id')
            ->withPivot(['id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscritos()
    {
        return $this->hasMany(Aluno::class, 'incricao_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxa()
    {
        return $this->belongsTo(Taxa::class, 'taxa_id');
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
        # Pivot para Curso
        if ($parent instanceof Curso) {
            return new PivotInscritoCurso($parent, $attributes, $table, $exists);
        }

        # Retorno do novo pivot
        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAtivo($query, $value)
    {
        return $query->where("ativo", $value);
    }
}