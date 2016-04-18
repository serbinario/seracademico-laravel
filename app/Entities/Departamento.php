<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Departamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'departamentos';

    protected $fillable = [ 
		'nome',
		'sede_id',
	];

}