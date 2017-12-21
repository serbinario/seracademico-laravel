<?php

namespace Seracademico\Entities\Emais;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MateriaAluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pre_alunos_materias";

    protected $fillable = [
        'pre_aluno_id',
        'pre_materia_id',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'pre_aluno_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'pre_materia_id');
    }
}