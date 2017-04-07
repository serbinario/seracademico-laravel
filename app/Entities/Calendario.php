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
    ];
}
