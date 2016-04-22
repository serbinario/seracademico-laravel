<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Nota extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_notas';

    protected $fillable = [ 
		'media',
		'aluno_tuma_id',
		'disciplina_id',
		'situacao_nota_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, "disciplina_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function situacao()
    {
        return $this->belongsTo(SituacaoNota::class, "situacao_nota_id");
    }
}