<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EstadoCivil extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "estados_civis";

    protected $fillable = [
        'nome'
    ];

}
