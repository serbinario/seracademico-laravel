<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AlunoFrequencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_alunos_frequencias';

    protected $fillable = [ 
		'pos_aluno_nota_id',
		'frequencia',
        'calendario_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alunoNota()
    {
        return $this->belongsTo(AlunoNota::class, 'pos_aluno_nota_id');
    }

}