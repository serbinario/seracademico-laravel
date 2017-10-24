<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Parametro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fin_parametros';

    protected $fillable = [
        'nome',
        'taxa_id',
        'codigo',
    ];

    public function taxa()
    {
        return $this->belongsTo(Taxa::class, 'taxa_id');
    }
}
