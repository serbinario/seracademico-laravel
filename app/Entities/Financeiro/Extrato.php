<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Extrato extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fin_extratos';

    protected $fillable = [
        'conta_bancaria_id',
        'debito_id',
        'balanco',
        'valor'
    ];

    public function contaBancaria()
    {
        return $this->belongsTo(ContaBancaria::class, 'conta_bancaria_id');
    }

    public function debito()
    {
        return $this->belongsTo(Debito::class, 'debito_id');
    }
}
