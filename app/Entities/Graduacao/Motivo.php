<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Motivo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_motivos';

    protected $fillable = [
        'codigo',
        'nome'
    ];

}
