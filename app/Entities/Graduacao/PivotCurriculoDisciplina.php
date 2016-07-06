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
}