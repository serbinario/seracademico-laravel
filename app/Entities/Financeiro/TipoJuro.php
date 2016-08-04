<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoJuro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipos_juros';

    protected $fillable = [ 
		'nome',
		'codigo',
	];

}