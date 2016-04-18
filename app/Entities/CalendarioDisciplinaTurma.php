<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Seracademico\Uteis\SerbinarioDateFormat;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CalendarioDisciplinaTurma extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * @var string
     */
    protected $table    = 'fac_calendarios';

    /**
     * @var array
     */
    protected $dates    = [
        'data',
        'data_final',
        'hora_inicial',
        'hora_final',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'data',
        'data_final',
        'hora_inicial',
        'hora_final',
        'sala_id',
        'professor_id',
        'turma_disciplina_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * @return \DateTime
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
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
    public function getHoraInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_inicial'], true);
    }

    /**
     * @return \DateTime
     */
    public function getHoraFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['hora_final'], true);
    }
}
