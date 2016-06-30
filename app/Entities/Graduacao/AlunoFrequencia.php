<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\SituacaoNota;

class AlunoFrequencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_alunos_frequencias';

    protected $fillable = [ 
		'falta_mes_1',
		'falta_mes_2',
        'falta_mes_3',
        'falta_mes_4',
        'falta_mes_5',
        'falta_mes_6',
        'total_falta',
        'aluno_nota_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alunoNota()
    {
        return $this->belongsTo(AlunoNota::class, 'aluno_nota_id');
    }
}