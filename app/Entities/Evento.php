<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Evento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'feriados_eventos';

    protected $fillable = [
        'nome',
        'data_feriado',
        'dia_semana',
        'dia_letivo_id',
    ];

    /**
     * @return \DateTime
     */
    public function getDataFeriadoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_feriado']);
    }

    /**
     * @return \DateTime
     */
    public function setDataFeriadoAttribute($value)
    {
        $this->attributes['data_feriado'] = SerbinarioDateFormat::toUsa($value);
    }
}
