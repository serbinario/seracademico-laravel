<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Seracademico\Entities\Professor;
use Seracademico\Entities\Sala;
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
        'data_final'
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
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_final']);
    }

    /**
     * @param $value
     */
    public function setDataFinalAttribute($value)
    {
        $this->attributes['data_final'] = SerbinarioDateFormat::toUsa($value);
    }
}
