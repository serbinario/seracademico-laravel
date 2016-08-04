<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Aluno;

class Boleto extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_boletos';

    protected $fillable = [ 
		'aluno_id',
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
        'debito_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function aluno()
	{
		return $this->belongsTo(Aluno::class, 'aluno_id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debito()
    {
        return $this->belongsTo(DebitoAbertoAluno::class, 'debito_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}