<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CursoSuperior extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fac_cursos_superiores";

    protected $fillable = [
        'nome',
        'fac_tipo_areas_id'
    ];

    public function aluno()
    {
        return $this->hasMany(Aluno::class, "fac_cursos_superiores_id");
    }

}
