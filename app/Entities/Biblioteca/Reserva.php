<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Aluno;

class Reserva extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_reservas';

    protected $fillable = [ 
		'codigo',
		'data',
		'data_vencimento',
		'alunos_id',
		'tipo_emprestimo',
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class, 'alunos_id');
	}

	public function reservaExemplar()
	{
		return $this->belongsToMany(Arcevo::class, 'bib_reservas_exemplares', 'reserva_id', "arcevos_id")
			->withPivot([ 'reserva_id', 'arcevos_id', 'edicao', 'status']);
	}

}