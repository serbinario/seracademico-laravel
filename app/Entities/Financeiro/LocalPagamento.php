<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class LocalPagamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_locais_pagamentos';

    protected $fillable = [ 
		'codigo',
		'nome',
	];

}