<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Estado extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "estados";

    protected $fillable = [
        'nome',
        'prefixo'
    ];

    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'estados_id');
    }
}
