<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AgendamentoAluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'pos_agendamento_alunos';

    protected $fillable = [
        'aluno_id',
        'agendamento_sc_id',
        'disciplina_id'
    ];
}
