<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Dia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_dias';

    protected $fillable = [
        'nome'
    ];

    /**
     * @param $query
     * @param $idTurma
     */
    public function scopeDiasValidos($query, $idTurma)
    {
        $query
            ->select(['fac_dias.id', 'fac_dias.nome'])
            ->whereNotIn('fac_dias.id', function ($query) use ($idTurma) {
                $query->from('fac_horarios')
                    ->select('fac_horarios.dia_id')
                    ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
                    ->where('fac_turmas.id', $idTurma)
                    ->groupBy('fac_horarios.dia_id')
                    ->having(\DB::raw('count(fac_horarios.dia_id)'), '=', 5)
                    ->get();
            })
        ;
    }
}
