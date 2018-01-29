<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Material extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'tec_materiais';

    protected $fillable = [
        'nome',
        'path',
        'modulo_id'
    ];

    public function modulo()
    {
        $this->belongsTo('modulo_id');
    }
}
