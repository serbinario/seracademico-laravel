<?php

namespace Seracademico\Entities\Emais;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Materia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pre_materias";

    protected $fillable = [
        'nome',
        'valor'
    ];
}