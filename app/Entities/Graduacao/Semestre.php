<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Semestre extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_semestres";

    protected $fillable = [
        'nome',
        'ativo'
    ];

}
