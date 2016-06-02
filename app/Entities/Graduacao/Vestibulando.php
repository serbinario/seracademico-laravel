<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\HorarioDisciplinaTurma;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\Graduacao\Vestibular;
use Seracademico\Uteis\SerbinarioDateFormat;

class Vestibulando extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_vestibulandos";

    protected $dates    = [
        'data_insricao_vestibular'
    ];

    protected $fillable = [
        'gerar_inscricao',
        'vestibular_id',
        'inscricao',
        'lingua_estrangeira_id',
        'pre_matricula',
        'data_insricao_vestibular',
        'sala_vestibular_id',
        'ano_enem',
        'inscricao_enem',
        'nota_humanas',
        'nota_natureza',
        'nota_matematica',
        'nota_linguagem',
        'nota_redacao',
        'ano_conclusao_medio',
        'outra_escola_medio',
        'primeira_opcao_curso_id',
        'segunda_opcao_curso_id',
        'terceira_opcao_curso_id',
        'primeira_opcao_turno_id',
        'segunda_opcao_turno_id',
        'terceira_opcao_turno_id',
        'pessoa_id'
    ];

    /**
     *
     * @return \DateTime
     */
    public function getInscricaoAttribute()
    {
        return $this->vestibular->codigo . $this->attributes['inscricao'];
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataInsricaoVestibularAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_insricao_vestibular']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataInsricaoVestibularAttribute($value)
    {
        $this->attributes['data_insricao_vestibular'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vestibular()
    {
        return $this->belongsTo(Vestibular::class, 'vestibular_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notasVestibular()
    {
        return $this->hasMany(VestibulandoNotaVestibular::class, 'vestibulando_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function horarios()
    {
        return $this->belongsToMany(HorarioDisciplinaTurma::class, "alunos_horarios", "aluno_id", "horario_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'vestibulando_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debitos()
    {
        return $this->hasMany(VestibulandoFinanceiro::class, 'vestibulando_id');
    }
}