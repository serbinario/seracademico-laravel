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
		'arcevos_id',
        'edicao',
        'status',
        'status_fila'
	];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function acervo()
    {
        return $this->belongsTo(Arcevo::class, 'arcevos_id');
    }

}