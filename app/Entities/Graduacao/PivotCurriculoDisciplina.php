<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Model;

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
        'periodo',
        'carga_horaria_total',
        'carga_horaria_teorica',
        'carga_horaria_pratica',
        'qtd_credito',
        'qtd_faltas',
        'pre_requisito_1_id',
        'pre_requisito_2_id',
        'pre_requisito_3_id',
        'pre_requisito_4_id',
        'pre_requisito_5_id',
        'co_requisito_1_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preRequisito1()
    {
        return $this->belongsTo(Disciplina::class, 'pre_requisito_1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preRequisito2()
    {
        return $this->belongsTo(Disciplina::class, 'pre_requisito_2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preRequisito3()
    {
        return $this->belongsTo(Disciplina::class, 'pre_requisito_3_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preRequisito4()
    {
        return $this->belongsTo(Disciplina::class, 'pre_requisito_4_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preRequisito5()
    {
        return $this->belongsTo(Disciplina::class, 'pre_requisito_5_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coRequisito1()
    {
        return $this->belongsTo(Disciplina::class, 'co_requisito_1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'fac_eletivas_semestres', 'curriculo_disciplina_id', 'semestre_id')
            ->withPivot(['id', 'curriculo_disciplina_id', 'semestre_id']);
    }

    /**
     * @param Model $parent
     * @param array $attributes
     * @param string $table
     * @param bool $exists
     * @return Pivot|EletivaSemestre
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Semestre) {
            return new EletivaSemestre($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}