<?php

namespace Seracademico\Entities\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\CursoPosGraduacao;
use Seracademico\Entities\CursoSuperior;
use Seracademico\Entities\Financeiro\Debito;
use Seracademico\Entities\Tecnico\Curso;
use Seracademico\Entities\Pessoa;
use Seracademico\Uteis\SerbinarioDateFormat;

class Aluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pos_alunos";

    protected $dates = [
        'data_contrato',
        'data_inscricao',
        'data_colacao',
        'data_conclusao'
    ];

    protected $fillable = [
        'matricula',
        'data_inscricao',
        'pessoa_id',
        'turno_id',
        'path_image',
        'curso_pretendido_1_id',
        'curso_pretendido_2_id',
        'curso_pretendido_3_id',
        'obs_cursos_pretendidos',
        'canal_captacao_id',
        'tipo_pretensao_id',
        'tipo_img',
        'data_contrato',
        'data_matricula',
        'titulo',
        'nota_final',
        'defesa',
        'media',
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
        'data_colacao',
        'tipo_aluno_id',
        'curriculo_doc_obrigatorio',
        'carta_intencao_doc_obrigatorio',
        'termo_biblioteca',
        'curso_superior_id',
        'curso_pos_graduacao_id',
        'fac_instituicao_id',
        'password',
        'login',
        'anotacao'
    ];

    /**
     * @return \DateTime
     */
    public function getDataInscricaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inscricao']);
    }

    /**
     * @return \DateTime
     */
    public function setDataInscricaoAttribute($value)
    {
        $this->attributes['data_inscricao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataConclusaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_conclusao']);
    }

    /**
     * @return \DateTime
     */
    public function setDataConclusaoAttribute($value)
    {
        $this->attributes['data_conclusao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataColacaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_colacao']);
    }

    /**
     * @return \DateTime
     */
    public function setDataColacaoAttribute($value)
    {
        $this->attributes['data_colacao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return string
     */
    public function getDataMatriculaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_matricula']);
    }

    /**
     * @param $value
     */
    public function setDataMatriculaAttribute($value)
    {
        $this->attributes['data_matricula'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function curriculos()
    {
        return $this->belongsToMany(Curriculo::class, 'pos_alunos_cursos', 'aluno_id', 'curriculo_id')->withPivot(['id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPretensao()
    {
        return $this->belongsTo(TipoPretensao::class, 'tipo_pretensao_id');
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
        if ($parent instanceof Curriculo) {
            return new PivotAlunoCurso($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cursoPosGraduacao()
    {
        return $this->belongsTo(CursoPosGraduacao::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cursoSuperior()
    {
        return $this->belongsTo(CursoSuperior::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function debitos()
    {
        return $this->morphMany(Debito::class, "debotante");
    }
}