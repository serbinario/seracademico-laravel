<?php

namespace Seracademico\Entities\Tecnico;

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
        'turma_id'
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
    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function situacao()
    {
        return $this->belongsTo(SituacaoNota::class, 'situacao_nota_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function frequencias()
    {
        return $this->hasMany(AlunoFrequencia::class, 'pos_aluno_nota_id');
    }

    /**
     *  Observer para deletar as frequências
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($alunoNota) {
            $alunoNota->frequencias()->delete();
        });
    }
}