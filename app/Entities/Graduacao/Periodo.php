<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Periodo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_periodos";

    protected $fillable = [
        'nome',
        'ativo'
    ];

}
