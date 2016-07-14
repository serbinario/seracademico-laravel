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
        'curriculo_id',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function frequencia()
    {
        return $this->hasOne(AlunoFrequencia::class, 'aluno_nota_id');
    }

    /**
     *  Observer para deletar as frequências
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($alunoNota) {
            $alunoNota->frequencia->delete();
        });
    }
}