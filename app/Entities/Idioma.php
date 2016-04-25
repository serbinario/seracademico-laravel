<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Idioma extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_idiomas';

    protected $fillable = [ 
		'nome',
	];

}