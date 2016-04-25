<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Responsavel extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'responsaveis';

    protected $fillable = [ 
		'nome',
		'sobrenome',
	];

}