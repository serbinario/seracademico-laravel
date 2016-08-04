<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoDebito extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipos_debitos';

    protected $fillable = [ 
		'nome',
		'codigo',
	];

}