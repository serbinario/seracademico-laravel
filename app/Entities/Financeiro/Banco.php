<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Banco extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_bancos';

    protected $fillable = [
        'codigo',
		'nome',
	];

}