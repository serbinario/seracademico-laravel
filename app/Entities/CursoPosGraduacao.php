<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Mestrado\Aluno;

class CursoPosGraduacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fac_cursos_pos_graduacoes";

    protected $fillable = [
        'nome',
        'nivel'
    ];

    public function aluno()
    {
        return $this->hasMany(Aluno::class);
    }

}
