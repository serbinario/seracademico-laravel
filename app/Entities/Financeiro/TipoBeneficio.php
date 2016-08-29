<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class TipoBeneficio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipos_beneficios';

    protected $dates    = [
        'valido_inicio',
        'valido_fim',
        'data_inicio',
        'data_fim'
    ];

    protected $fillable = [
        'codigo',
		'nome',
		'valido_inicio',
		'valido_fim',
		'data_inicio',
		'data_fim',
		'valor',
		'tipo_id',
		'incidencia_id',
		'dia_inicial_id',
		'dia_final_id',
		'tipo_dia_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficios()
    {
        return $this->hasMany(Beneficio::class, 'tipo_beneficio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidencia()
    {
        return $this->belongsTo('Seracademico\Entities\Financeiro\Incidencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoValor()
    {
        return $this->belongsTo('Seracademico\Entities\Financeiro\TipoValor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDia()
    {
        return $this->belongsTo('Seracademico\Entities\Financeiro\TipoDia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataNascimento()
    {
        return $this->belongsTo('Seracademico\Entities\Financeiro\DataNascimento');
    }

    /**
     *
     * @return \DateTime
     */
    public function getValidoInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_inicio']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setValidoInicioAttribute($value)
    {
        $this->attributes['valido_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getValidoFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_fim']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setValidoFimAttribute($value)
    {
        $this->attributes['valido_fim'] = SerbinarioDateFormat::toUsa($value);
    }


    /**
     * @return string
     */
    public function getDataInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inicio']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataInicioAttribute($value)
    {
        $this->attributes['data_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_fim']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataFimAttribute($value)
    {
        $this->attributes['data_fim'] = SerbinarioDateFormat::toUsa($value);
    }

}