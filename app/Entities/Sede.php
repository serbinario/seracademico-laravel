<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Sede extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'sedes';

    protected $fillable = [ 
		'nome',
        'representante',
        'telefone',
        'endereco_id'
	];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

}