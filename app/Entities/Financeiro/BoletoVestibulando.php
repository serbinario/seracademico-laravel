<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Entities\Graduacao\VestibulandoFinanceiro;

class BoletoVestibulando extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_boletos_vestibulandos';

    protected $fillable = [ 
		'vestibulando_id',
		'banco_id',
		'nosso_numero',
		'empresa_id',
		'agencia',
		'conta',
		'data',
		'numero',
		'especie',
		'carteira',
		'aceite',
		'moeda',
		'instrucao',
		'vencimento',
		'local_pagamento',
		'itpe',
        'vestibulando_financeiro_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function vestibulando()
	{
		return $this->belongsTo(Vestibulando::class, 'vestibulando_id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debito()
    {
        return $this->belongsTo(VestibulandoFinanceiro::class, 'vestibulando_financeiro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}