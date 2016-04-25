<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Empresa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'empresas';

    protected $fillable = [ 
		'nome',
        'cnpj',
        'inscricao_municipal',
        'inscricao_estadual',
        'endereco_id'
	];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

}