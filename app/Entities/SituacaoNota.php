<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SituacaoNota extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = "fac_situacao_nota";

    /**
     * @var array
     */
    protected $fillable = [
        'nome',
        'codigo'
    ];

}
