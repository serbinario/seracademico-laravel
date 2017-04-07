<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CalendarioDuracao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fac_calendarios_duracao';

    protected $fillable = [
        'nome'
    ];

}
