<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AgendamentoTipoProva extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'pos_agendamentos_tipos_provas';

    protected $fillable = [
        'nome',
    ];
}
