<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Dia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_dias';

    protected $fillable = [
        'nome'
    ];

}
