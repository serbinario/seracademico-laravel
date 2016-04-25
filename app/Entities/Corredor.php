<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Corredor extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_corredor';

    protected $fillable = [ 
		'nome',
	];

}