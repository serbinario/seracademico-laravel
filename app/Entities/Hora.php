<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\HorarioDisciplinaTurma;
use Seracademico\Uteis\SerbinarioDateFormat;

class Hora extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_horas';

    protected $fillable = [
        'nome',
        'hora_inicial',
        'hora_final',
        'turno_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

     /**
      *
      * @return \DateTime
      */
    public function getHoraInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_inicial'], true);
    }

    /**
     *
     * @return \DateTime
     */
    public function setHoraInicialAttribute($value)
    {
        $this->attributes['hora_inicial'] = SerbinarioDateFormat::toUsa($value, true);
    }

    /**
     *
     * @return \DateTime
     */
    public function getHoraFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_final'], true);
    }

    /**
     *
     * @return \DateTime
     */
    public function setHoraFinalAttribute($value)
    {
        $this->attributes['hora_final'] = SerbinarioDateFormat::toUsa($value, true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany(HorarioDisciplinaTurma::class, 'hora_id');
    }
}
