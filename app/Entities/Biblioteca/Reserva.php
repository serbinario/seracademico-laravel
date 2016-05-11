<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Reserva extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_reservas';

    protected $fillable = [ 
		'codigo',
		'data',
		'data_vencimento',
		'user_id',
	];

}