<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Model;

class PivotDisciplinaAgendamento extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_disciplina_agendamento_sc';

    protected $fillable = [
        'disciplina_id',
        'agendamento_sc_id',
    ];

    public function disciplinas()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }


}