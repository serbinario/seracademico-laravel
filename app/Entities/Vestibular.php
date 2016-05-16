<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Curso;
use Seracademico\Entities\PivotVestibularCurso;
use Seracademico\Uteis\SerbinarioDateFormat;

class Vestibular extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'vestibulares';

	protected $dates    = [
        'data_inicial',
        'data_final',
        'data_prova'
    ];

    protected $fillable = [ 
		'codigo',
		'nome',
		'data_inicial',
		'data_final',
		'hora_inicial',
		'hora_final',
		'qtd_vagas',
		'instrucoes_boleto',
		'confirmacao_inscricao',
		'banco_id',
		'taxa_id',
		'tipo_vencimento_id',
		'qtd_dias',
		'data_prova',
        'semestre_id'
	];

    /**
     * @return string
     */
    public function getDataInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inicial']);
    }

    /**
     * @return string
     */
    public function setDataInicialAttribute($value)
    {
        return $this->attributes['data_inicial'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return string
     */
    public function getDataFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_final']);
    }

    /**
     * @return string
     */
    public function setDataFinalAttribute($value)
    {
        $this->attributes['data_final'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return string
     */
    public function getHoraInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_inicial'], true);
    }

    /**
     * @return string
     */
    public function setHoraInicialAttribute($value)
    {
        $this->attributes['hora_inicial'] = SerbinarioDateFormat::toUsa($value, true);
    }

    /**
     * @return string
     */
    public function getHoraFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_final'], true);
    }

    /**
     * @return string
     */
    public function setHoraFinalAttribute($value)
    {
        $this->attributes['hora_final'] = SerbinarioDateFormat::toUsa($value, true);
    }

    /**
     * @return string
     */
    public function getDataProvaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_prova']);
    }

    /**
     * @return string
     */
    public function setDataProvaAttribute($value)
    {
        $this->attributes['data_prova'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxa()
    {
        return $this->belongsTo(Taxa::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoVencimento()
    {
        return $this->belongsTo(TipoVencimento::class, 'tipo_vencimento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'vestibulares_cursos', 'vestibular_id', 'curso_id')
            ->withPivot(['id']);
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
            return new PivotVestibularCurso($parent, $attributes, $table, $exists);
        }

        # Retorno do novo pivot
        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}