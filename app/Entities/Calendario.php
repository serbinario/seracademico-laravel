<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Calendario extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fac_calendarios_escolares';

    protected $fillable = [
        'nome',
        'ano',
        'data_inicial',
        'data_final',
        'dias_letivos',
        'semanas_letivas',
        'status_id',
        'duracao_id',
        'data_resultado_final'
    ];

    /**
     * @return \DateTime
     */
    public function getDataInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inicial']);
    }

    /**
     * @return \DateTime
     */
    public function setDataInicialAttribute($value)
    {
        $this->attributes['data_inicial'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_final']);
    }

    /**
     * @return \DateTime
     */
    public function setDataFinalAttribute($value)
    {
        $this->attributes['data_final'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataResultadoFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_resultado_final']);
    }

    /**
     * @return \DateTime
     */
    public function setDataResultadoFinalAttribute($value)
    {
        $this->attributes['data_resultado_final'] = SerbinarioDateFormat::toUsa($value);
    }
}
