<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\SituacaoNota;

class AlunoNota extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_alunos_notas';

    protected $fillable = [ 
		'nota_unidade_1',
		'nota_unidade_2',
        'nota_2_chamada',
        'nota_final',
        'nota_media',
        'situacao_id',
        'aluno_curso_id',
        'aluno_semestre_id',
        'turma_disciplina_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function situacao()
    {
        return $this->belongsTo(SituacaoNota::class, 'situacao_id');
    }
}