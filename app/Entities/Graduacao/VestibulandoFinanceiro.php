<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Financeiro\FormaPagamento;
use Seracademico\Entities\Financeiro\LocalPagamento;
use \Seracademico\Entities\Financeiro\Taxa;
use Seracademico\Uteis\SerbinarioDateFormat;

class VestibulandoFinanceiro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_vestibulandos_financeiros';

    protected $dates    = [
        'vencimento',
        'data_pagamento'
    ];

    protected $fillable = [ 
		'taxa_id',
		'valor_debito',
        'valor_desconto',
        'vencimento',
        'mes_referencia',
        'ano_referencia',
        'observacao',
        'vestibulando_id',
        'pago',
        'data_pagamento',
        'forma_pagamento_id',
        'local_pagamento_id',
        'valor_multa',
        'valor_juros',
        'valor_pago'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxa()
    {
        return $this->belongsTo(Taxa::class, 'taxa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localPagamento()
    {
        return $this->belongsTo(LocalPagamento::class, 'local_pagamento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }
    
    /**
     *
     * @return \DateTime
     */
    public function setVencimentoAttribute($value)
    {
        $this->attributes['vencimento'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getVencimentoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['vencimento']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataPagamentoAttribute($value)
    {
        $this->attributes['data_pagamento'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataPagamentoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_pagamento']);
    }
}