<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoAutor extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'tipo_autor';

    protected $fillable = [ 
		'nome',
	];

}