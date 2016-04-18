<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Instituicao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fac_instituicoes";

    protected $fillable = [
        'nome',
        'nivel'
    ];

    public function alunos()
    {
        return $this->hasMany(Aluno::class, 'fac_instituicoes_id');
    }

}
