<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Turma extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_turmas';

    protected $dates    = [
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final',
        'vencimento_inicial'
    ];

    protected $fillable = [ 
		'curriculo_id',
		'turno_id',
		'sigla',
		'valor_turma',
		'valor_disciplina',
		'sala_id',
		'obs_sala',
		'codigo',
        'matricula_inicio',
        'matricula_fim',
        'aula_inicio',
        'aula_final',
        'qtd_parcelas',
        'maximo_vagas',
        'minimo_vagas',
        'observacao_vagas',
        'vencimento_inicial',
        'tipo_nivel_sistema_id',
        'duracao_meses'
	];

    /**
     * @return \DateTime
     */
    public function getMatriculaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['matricula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function setMatriculaInicioAttribute($value)
    {
        $this->attributes['matricula_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getMatriculaFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['matricula_fim']);
    }

    /**
     * @return \DateTime
     */
    public function setMatriculaFimAttribute($value)
    {
        $this->attributes['matricula_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getAulaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['aula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function setAulaInicioAttribute($value)
    {
        $this->attributes['aula_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getAulaFinalAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['aula_final']);
    }

    /**
     * @return \DateTime
     */
    public function setAulaFinalAttribute($value)
    {
        $this->attributes['aula_final'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getVencimentoInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['vencimento_inicial']);
    }

    /**
     * @return \DateTime
     */
    public function setVencimentoInicialAttribute($value)
    {
        $this->attributes['vencimento_inicial'] = SerbinarioDateFormat::toUsa($value);;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curriculo()
    {
        return $this->belongsTo(Curriculo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * @return mixed
     */
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, "fac_turmas_disciplinas", "turma_id", "disciplina_id")
            ->withPivot(['id', 'turma_id', 'disciplina_id']);
    }

    /**
     * @return $this
     */
    public function alunosCursos()
    {
        return $this->belongsToMany(PivotAlunoCurso::class, "pos_alunos_turmas", "turma_id", "pos_aluno_curso_id")
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
     * @param Model $parent
     * @param array $attributes
     * @param string $table
     * @param bool $exists
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        # Pivot para disciplina
        if ($parent instanceof Disciplina) {
            return new TurmaDisciplina($parent, $attributes, $table, $exists);
        }

        # Pivot para curso do aluno de pós
        if ($parent instanceof PivotAlunoCurso) {
            return new AlunoTurma($parent, $attributes, $table, $exists);
        }


        # Retorno do novo pivot
        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePosGraduacao($query)
    {
        return $query->select(['fac_turmas.id', 'fac_turmas.codigo as nome'])->where('tipo_nivel_sistema_id', 2);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePosGraduacaoByAlunoCurso($query, $idAlunoCurso)
    {
        # Query personalizada
        return $query
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->select(['fac_turmas.id', 'fac_turmas.codigo as nome'])
            ->whereNotIn('fac_turmas.id', function ($query) use ($idAlunoCurso){
                $query->from('pos_alunos_cursos')
                ->join('pos_alunos_turmas', function ($join) {
                    $join->on(
                        'pos_alunos_turmas.id', '=',
                        \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                    );
                })
                ->select([
                    'pos_alunos_turmas.turma_id'
                ]);
            })
            ->where('pos_alunos_cursos.id', $idAlunoCurso)
            ->where('fac_turmas.tipo_nivel_sistema_id', 2);
    }
}