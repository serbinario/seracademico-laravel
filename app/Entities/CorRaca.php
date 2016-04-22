<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CorRaca extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "cores_racas";

    protected $fillable = [
        'nome'
    ];

}
