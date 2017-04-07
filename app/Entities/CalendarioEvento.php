<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class CalendarioEvento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'feriados_eventos';

    protected $fillable = [
        'nome',
        'data_feriado',
        'dia_semana',
        'tipo_evento_id',
        'dia_letivo_id',
        'calendarios_id',
    ];

    /**
     * @return string
     */
    public function getDataFeriadoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_feriado']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataFeriadoAttribute($value)
    {
        $this->attributes['data_feriado'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class, 'tipo_evento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diaLetivo()
    {
        return $this->belongsTo(DiaLetivo::class, 'dia_letivo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendario()
    {
        return $this->belongsTo(Calendario::class, 'calendarios_id');
    }
}
