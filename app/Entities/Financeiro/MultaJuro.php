<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MultaJuro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_multas_juros';

    protected $fillable = [ 
		'valor_multa',
		'valor_juros',
		'tipo_multa_id',
		'tipo_juro_id',
	];

}