<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CalendarioStatus extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fac_calendarios_status';

    protected $fillable = [
        'nome'
    ];

}
