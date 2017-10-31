<?php
namespace Seracademico\Entities\Financeiro;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Contracts\GnetBoleto;

class Boleto extends Model implements Transformable, GnetBoleto
{
    use TransformableTrait;

    protected $table = 'fin_boletos';

    protected $fillable = [
		'banco_id',
        'debito_id',
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
        'gnet_valor',
        'gnet_quantidade',
        'gnet_nome',
        'gnet_link',
        'gnet_charge',
        'gnet_status_id',
        'gnet_parcel',
        'gnet_barcode'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debito()
    {
        return $this->belongsTo(Debito::class, 'debito_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->gnet_nome;
    }

    /**
     * @return mixed
     */
    public function getQtd()
    {
        return 1;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return (integer) $this->gnet_valor * 100;
    }

    /**
     * @return string
     */
    public function getDueDate()
    {
        $vencimento = Carbon::createFromFormat('d/m/Y', $this->vencimento);
        return $vencimento->format('Y-m-d');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusGnet()
    {
        return $this->belongsTo(StatusBoletoGnet::class, 'gnet_status_id');
    }
}