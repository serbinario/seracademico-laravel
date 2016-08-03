<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Banco extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_bancos';

    protected $fillable = [ 
		'codigo',
		'nome',
		'numero_banco',
		'status',
		'numero_conta',
		'numero_agencia',
		'numero_convenio',
		'carteira',
		'carteira_var',
		'mascara_nn',
		'tipo_moeda_id',
		'aceite',
		'especie',
		'local_pagamento',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function tipoMoeda()
	{
		return $this->belongsTo(TipoMoeda::class, 'tipo_moeda_id');
	}
}