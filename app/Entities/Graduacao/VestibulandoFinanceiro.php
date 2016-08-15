<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use \Seracademico\Entities\Financeiro\Taxa;
use Seracademico\Uteis\SerbinarioDateFormat;

class VestibulandoFinanceiro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_vestibulandos_financeiros';

    protected $dates    = [
        'vencimento'
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
        'pago'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxa()
    {
        return $this->belongsTo(Taxa::class, 'taxa_id');
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
}