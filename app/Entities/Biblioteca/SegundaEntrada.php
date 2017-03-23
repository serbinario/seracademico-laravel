<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SegundaEntrada extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'segunda_entrada';

    protected $fillable = [ 
		'tipo_autor_id',
		'arcevos_id',
		'responsaveis_id',
		'para_referencia1',
		'para_referencia2',
		'para_referencia3',
		'exibir_tipo1',
		'exibir_tipo2',
		'exibir_tipo3'
	];

	public function tipoAutor()
	{
		return $this->belongsTo(TipoAutor::class, 'tipo_autor_id');
	}

	public function acervos()
	{
		return $this->belongsTo(Arcevo::class, 'arcevos_id');
	}

	public function responsaveis()
	{
		return $this->belongsTo(Responsavel::class, 'responsaveis_id');
	}

}