<?php

namespace Seracademico\Entities\Emais;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Modalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pre_modalidades";

    protected $fillable = [
        'nome',
    ];

    public function modalidades()
    {
        return $this->hasMany(ModalidadeAluno::class, 'pre_modalidade_id', 'id');
    }
}