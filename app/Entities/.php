<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BibParametro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_parametros';

    protected $fillable = [ 
		'nome',
		'valor',
		'codigo',
	];

}