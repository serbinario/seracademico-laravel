<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Fechamento extends Model implements Transformable
{
    use TransformableTrait;

	/**
	 * @var string
	 */
    protected $table    = 'fin_fechamentos';

	/**
	 * @var array
	 */
    protected $fillable = [ 
		'debito_id',
		'valor_pago',
		'data_fechamento',
		'valor_juros',
		'valor_tipo_juros',
		'valor_multa',
		'valor_tipo_multa',
		'valor_desconto',
		'valor_tipo_desconto',
		'valor_acrescimo',
		'valor_tipo_acrescimo',
		'valor_descrecimo',
		'valor_tipo_descrecimo',
		'valor_total',
		'forma_pagamento_id',
		'local_pagamento_id',
	];

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
	public function formaPagamento()
	{
		return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function localPagamento()
	{
		return $this->belongsTo(LocalPagamento::class, 'local_pagamento_id');
	}
}