<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Evento extends Model implements Transformable
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

}
