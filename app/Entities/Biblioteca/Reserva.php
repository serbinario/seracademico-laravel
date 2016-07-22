<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Aluno;
use Seracademico\Entities\Pessoa;

class Reserva extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_reservas';

    protected $fillable = [ 
		'codigo',
		'data',
		'data_vencimento',
		'pessoas_id',
		'tipo_emprestimo',
		'status'
	];

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoas_id');
	}

	public function reservaExemplar()
	{
		return $this->belongsToMany(Arcevo::class, 'bib_reservas_exemplares', 'reserva_id', "arcevos_id")
			->withPivot(['id', 'reserva_id', 'arcevos_id', 'edicao', 'status']);
	}

}