<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Modulo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'tec_modulos';

    protected $fillable = [
        'nome',
        'codigo',
        'curriculo_id'
    ];

    /**
     * @return mixed
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'fac_curriculo_disciplina', 'modulo_id', 'disciplina_id')
            ->withPivot(['id', 'modulo_id', 'disciplina_id']);
    }
}
