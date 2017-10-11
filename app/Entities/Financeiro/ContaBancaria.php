<?php
namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ContaBancaria extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fin_contas_bancarias';

    protected $fillable = [
        'nome',
        'codigo',
        'agencia',
        'conta',
        'balanco',
        'banco_id',
        'ativo'
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

}
