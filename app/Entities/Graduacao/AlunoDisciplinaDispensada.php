<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class AlunoDisciplinaDispensada extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'fac_alunos_semestres_disciplinas_dispensadas';

    /**
     * @var array
     */
    protected $dates = [
        'data'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'disciplina_id',
        'motivo_id',
        'media',
        'qtd_credito',
        'carga_horaria',
        'aluno_semestre_id',
        'instituicao_id',
        'data'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function motivo()
    {
        return $this->belongsTo(Motivo::class, 'motivo_id');
    }

    /**
     * @return string
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     * @return string
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }
}