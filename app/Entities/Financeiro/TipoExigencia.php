<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoExigencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipos_exigencias';

    protected $fillable = [ 
		'nome',
		'codigo'
	];

}