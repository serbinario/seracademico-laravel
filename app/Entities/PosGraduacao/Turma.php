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
        'tipo_nivel_sistema_id'
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
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, "fac_alunos_turmas", "turma_id", "aluno_id")
            ->withPivot(['id', 'aluno_id', 'disciplina_id']);
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

        # Pivot para Aluno
        if($parent instanceof Aluno) {
            return new AlunoTurma($parent, $attributes, $table, $exists);
        }

        # Retorno do novo pivot
        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}