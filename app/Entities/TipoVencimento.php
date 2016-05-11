<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoVencimento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'tipos_vencimentos';

    protected $fillable = [ 
		'codigo',
		'nome',
	];

}