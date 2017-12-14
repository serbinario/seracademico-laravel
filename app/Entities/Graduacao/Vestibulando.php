<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Entities\Graduacao\HorarioDisciplinaTurma;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\Graduacao\Vestibular;
use Seracademico\Entities\Turno;
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
        'pessoa_id',
        'path_comprovante_enem',
        'path_comprovante_endereco',
        'path_comprovante_ficha19',
        'ficha_nota_portugues',
        'ficha_nota_matematica',
        'ficha_nota_historia',
        'ficha_nota_geografia',
        'ficha_nota_sociologia',
        'ficha_nota_filosofia',
        'ficha_nota_biologia',
        'ficha_nota_lingua_estrangeira',
        'ficha_nota_quimica',
        'ficha_nota_fisica',
        'media_enem',
        'media_ficha',
        'enem',
        'path_image',
        'tipo_img',
        'agendamento_id',
        'nota_vestibular_redacao'
    ];


    public function getDataInsricaoVestibularAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_insricao_vestibular']);
    }

    public function setDataInsricaoVestibularAttribute($value)
    {
        $this->attributes['data_insricao_vestibular'] = SerbinarioDateFormat::toUsa($value);
    }

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function vestibular()
    {
        return $this->belongsTo(Vestibular::class, 'vestibular_id');
    }

    public function notasVestibular()
    {
        return $this->hasMany(VestibulandoNotaVestibular::class, 'vestibulando_id');
    }

    public function horarios()
    {
        return $this->belongsToMany(HorarioDisciplinaTurma::class, "alunos_horarios", "aluno_id", "horario_id");
    }

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'vestibulando_id');
    }

    public function debitos()
    {
        return $this->morphMany(Debito::class, 'debitante');
    }

    public function primeiraOpcaoCurso()
    {
        return $this->belongsTo(Curso::class, 'primeira_opcao_curso_id');
    }

    public function segundaOpcaoCurso()
    {
        return $this->belongsTo(Curso::class, 'segunda_opcao_curso_id');
    }

    public function terceiraOpcaoCurso()
    {
        return $this->belongsTo(Curso::class, 'terceira_opcao_curso_id');
    }

    public function primeiraOpcaoTurno()
    {
        return $this->belongsTo(Turno::class, 'primeira_opcao_turno_id');
    }

    public function segundaOpcaoTurno()
    {
        return $this->belongsTo(Turno::class, 'segunda_opcao_turno_id');
    }

    public function terceiraOpcaoTurno()
    {
        return $this->belongsTo(Turno::class, 'terceira_opcao_turno_id');
    }
}