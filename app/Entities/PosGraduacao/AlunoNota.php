<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\SituacaoNota;

class AlunoNota extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_alunos_notas';

    protected $fillable = [ 
		'pos_aluno_turma_id',
		'disciplina_id',
		'nota_final',
		'situacao_nota_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function situacao()
    {
        return $this->belongsTo(SituacaoNota::class, 'situacao_nota_id');
    }
}