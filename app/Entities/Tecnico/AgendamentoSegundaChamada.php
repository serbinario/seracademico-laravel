<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class AgendamentoSegundaChamada extends Model implements Transformable
{
    use TransformableTrait;

    protected $dates = [
        'data',
    ];

    protected $table = 'pos_agendamentos_segunda_chamada';

    protected $fillable = [
        'data',
        'hora_inicio',
        'hora_final',
        'hora_entrada',
        'agendamento_tp_id',
    ];

    /**
     * @return \DateTime
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     * @return \DateTime
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'pos_disciplina_agendamento_sc', 'agendamento_sc_id', "disciplina_id")
            ->withPivot(['id', 'agendamento_sc_id', 'disciplina_id']);
    }

}
