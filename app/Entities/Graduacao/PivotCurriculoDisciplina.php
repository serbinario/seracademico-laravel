<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class PivotCurriculoDisciplina extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'fac_curriculo_disciplina';

    /**
     * @var array
     */
    protected $fillable = [
        'curriculo_id',
        'disciplina_id',
        'periodo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplinasPreRequisitos()
    {
        return $this->belongsToMany(Disciplina::class, "fac_disciplina_pre_requisitos", "curriculo_disciplina_id", "disciplina_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplinasCoRequisitos()
    {
        return $this->belongsToMany(Disciplina::class, "fac_disciplina_co_requisito", "curriculo_disciplina_id", "disciplina_id");
    }
}