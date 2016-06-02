<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Semestre extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_semestres";

    protected $fillable = [
        'nome',
        'ativo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'fac_alunos_semestres', 'semestre_id', 'aluno_id');
    }
    
    /**
     * @param Model $parent
     * @param array $attributes
     * @param string $table
     * @param bool $exists
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Aluno) {
            return new PivotAlunoSemestre($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
