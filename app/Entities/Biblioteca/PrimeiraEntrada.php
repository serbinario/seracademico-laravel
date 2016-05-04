<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PrimeiraEntrada extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'primeira_entrada';

    protected $fillable = [
		'arcevos_id',
		'responsaveis_id',
	];

	public function acervos()
	{
		return $this->belongsTo(Arcevo::class, 'arcevos_id');
	}

	public function responsaveis()
	{
		return $this->belongsTo(Responsavel::class, 'responsaveis_id');
	}

}