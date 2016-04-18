<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoSanguinio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "tipos_sanguinios";

    protected $fillable = [
        'nome'
    ];

}
