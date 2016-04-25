<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoPrecoCurso extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_tipos_precos_cursos";

    protected $fillable = [
        'nome',
        'codigo'
    ];

}
