<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EletivaSemestre extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'fac_eletivas_semestres';

    /***
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplinasEletivas()
    {
        return $this->belongsToMany(Disciplina::class, 'fac_eletivas_disciplinas', 'eletiva_semestre_id', 'disciplina_id')
            ->withPivot(['id', 'eletiva_semestre_id', 'disciplina_id']);
    }
}

///**
// * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
// */
//public function semestresEletivas()
//{
//    return $this->belongsToMany(Semestre::class, 'fac_eletivas_semestres', 'turma_disciplina_id', 'semestre_id');
//}