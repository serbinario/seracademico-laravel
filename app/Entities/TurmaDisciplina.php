<?php

namespace Seracademico\Entities;

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
    public function calendarios()
    {
        return $this->hasMany(CalendarioDisciplinaTurma::class, 'turma_disciplina_id');
    }

}