<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\CorRaca;
use Seracademico\Entities\Curso;
use Seracademico\Entities\CursoSuperior;
use Seracademico\Entities\Endereco;
use Seracademico\Entities\Estado;
use Seracademico\Entities\EstadoCivil;
use Seracademico\Entities\Exame;
use Seracademico\Entities\FormaAdmissao;
use Seracademico\Entities\GrauInstrucao;
use Seracademico\Entities\InclusaoALuno;
use Seracademico\Entities\Instituicao;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\Profissao;
use Seracademico\Entities\Religiao;
use Seracademico\Entities\Sexo;
use Seracademico\Entities\SituacaoAluno;
use Seracademico\Entities\TipoSanguinio;
use Seracademico\Entities\Turno;


class Aluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fac_alunos";

    protected $dates = [
        "data_transferencia"
    ];

    protected $fillable = [
        'matricula',
        'data_transferencia',
        'pessoa_id',
        'turno_id',
        'forma_admissao_id',
        'curriculo_id',
        'vestibulando_id'
    ];

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
    public function vestibulando()
    {
        return $this->belongsTo(Vestibulando::class, 'vestibulando_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formaAdmissao()
    {
        return $this->belongsTo(FormaAdmissao::class, 'forma_admissao_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curriculo()
    {
        return $this->belongsTo(Curriculo::class, 'curriculo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'fac_alunos_semestres', 'aluno_id', 'semestre_id')
            ->withPivot(['periodo']);
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
        if ($parent instanceof Semestre) {
            return new PivotAlunoSemestre($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

}