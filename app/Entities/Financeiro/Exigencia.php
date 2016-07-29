<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Exigencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_exigencias';

    protected $fillable = [ 
		'nome',
		'codigo',
		'tipo_exigencia_id',
	];

}