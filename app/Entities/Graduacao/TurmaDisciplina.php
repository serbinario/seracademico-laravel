<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TurmaDisciplina extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'fac_turmas_disciplinas';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany(HorarioDisciplinaTurma::class, 'turma_disciplina_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diarios()
    {
        return $this->hasMany(DiarioAula::class, 'turma_disciplina_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function semestresEletivas()
    {
        return $this->belongsToMany(Semestre::class, 'fac_eletivas_semestres', 'turma_disciplina_id', 'semestre_id');
    }
}