<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class AlunoTurma extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'pos_alunos_turmas';

    /**
     * @var array
     */
    protected $dates = [
        'data_conclusao',
        'data_colacao'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'turma_id',
        'aluno_id',
        'situacao_id',
        'titulo',
        'nota_final',
        'defesa',
        'madia',
        'media_conceito',
        'defendeu',
        'professor_orientador_id',
        'professor_banca_1_id',
        'professor_banca_2_id',
        'professor_banca_3_id',
        'professor_banca_4_id',
        'inst_ensino_banca_1_id',
        'inst_ensino_banca_2_id',
        'inst_ensino_banca_3_id',
        'inst_ensino_banca_4_id',
        'data_conclusao',
        'data_colacao'
    ];

    /**
     *
     * @return \DateTime
     */
    public function getDataConclusaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_conclusao']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataConclusaoAttribute($value)
    {
        $this->attributes['data_conclusao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataColacaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_colacao']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataColacaoAttribute($value)
    {
        $this->attributes['data_colacao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notas()
    {
        return $this->hasMany(AlunoNota::class, 'pos_aluno_turma_id');
    }
}