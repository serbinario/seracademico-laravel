<?php

namespace Seracademico\Entities\Emais;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModalidadeAluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pre_alunos_modalidades";

    protected $fillable = [
        'pre_aluno_id',
        'pre_modalidade_id',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'pre_aluno_id');
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'pre_modalidade_id');
    }
}