<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Taxa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'taxas';

    protected $fillable = [ 
		'codigo',
		'nome',
        'valor'
	];
}