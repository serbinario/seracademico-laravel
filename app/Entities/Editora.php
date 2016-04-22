<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Editora extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_editoras';

    protected $fillable = [ 
		'nome',
		'email',
		'site',
		'cnpj',
		'razao_social',
		'agencia',
		'conta',
		'enderecos_id',
	];

	public function endereco()
	{
		return $this->belongsTo(Endereco::class, 'enderecos_id');
	}

}