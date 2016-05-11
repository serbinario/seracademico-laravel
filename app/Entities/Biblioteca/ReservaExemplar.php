<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ReservaExemplar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_reservas_exemplares';

    protected $fillable = [ 
		'reserva_id',
		'exemplar_id',
	];

}