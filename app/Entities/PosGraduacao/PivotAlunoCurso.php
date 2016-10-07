<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\PosGraduacao\Turma;
use Seracademico\Entities\SituacaoAluno;
use Seracademico\Entities\Turno;
use Seracademico\Uteis\SerbinarioDateFormat;

class PivotAlunoCurso extends Pivot implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'pos_alunos_cursos';

    /**
     * @var array
     */
    protected $fillable = [
        'aluno_id',
        'curriculo_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, "pos_alunos_turmas", "pos_aluno_curso_id", "turma_id")
            ->withPivot([
                'id',
                'pos_aluno_curso_id',
                'turma_id',
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
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function situacoes()
    {
        return $this->belongsToMany(SituacaoAluno::class, "pos_alunos_situacoes", "pos_aluno_curso_id", "situacao_id");
    }
}