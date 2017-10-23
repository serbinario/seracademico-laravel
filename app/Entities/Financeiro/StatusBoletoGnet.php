<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StatusBoletoGnet extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fin_status_gnet";

    protected $fillable = [
        'nome',
        'codigo'
    ];

}
