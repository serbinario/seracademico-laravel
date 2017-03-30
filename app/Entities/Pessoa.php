<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Mestrado\Aluno;
use Seracademico\Uteis\SerbinarioDateFormat;


class Pessoa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = "pessoas";

    /**
     * @var array
     */
    protected $dates    = [
        'data_expedicao',
        'data_nasciemento',
        'data_exame_nacional_um',
        'data_exame_nacional_dois'
    ];

    protected $fillable = [
        'nome',
        'email',
        'telefone_fixo',
        'celular',
        'celular2',
        'nome_pai',
        'nome_social',
        'nome_mae',
        'identidade',
        'orgao_rg',
        'uf_exp',
        'data_expedicao',
        'cpf',
        'titulo_eleitoral',
        'zona',
        'secao',
        'resevista',
        'catagoria_resevista',
        'data_nasciemento',
        'nacionalidade',
        'naturalidade',
        'ano_conclusao_superior',
        'outra_instituicao',
        'data_exame_nacional_um',
        'nota_exame_nacional_um',
        'data_exame_nacional_dois',
        'nota_exame_nacional_dois',
        'enderecos_id',
        'sexos_id',
        'turnos_id',
        'grau_instrucoes_id',
        'profissoes_id',
        'religioes_id',
        'estados_civis_id',
        'tipos_sanguinios_id',
        'cores_racas_id',
        'exames1_id',
        'exames2_id',
        'uf_nascimento_id',
        'deficiencia_fisica',
        'deficiencia_auditiva',
        'deficiencia_visual',
        'deficiencia_outra',
        'instituicoes_id',
        'cursos_superiores_id',
        'ano_conclusao_superior',
        'tipo_nivel_sistema_id',
        'rg_doc_obrigatorio',
        'cpf_doc_obrigatorio',
        'certidao_nasc_cas_doc_obrigatorio',
        'titulo_eleitor_doc_obrigatorio',
        'reservista_doc_obrigatorio',
        'diploma_doc_obrigatorio',
        'fotos_3x4_doc_obrigatorio',
        'comp_residencia_doc_obrigatorio',
        'histo_gradu_autentic_obrigatorio',
        'ativo',
        'instituicao_escolar_id',
        'ano_conclusao_medio',
        'outra_escola'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'enderecos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turnos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grauInstrucao()
    {
        return $this->belongsTo(GrauInstrucao::class, 'grau_instrucoes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profissao()
    {
        return $this->belongsTo(Profissao::class, 'profissoes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function religiao()
    {
        return $this->belongsTo(Religiao::class, 'religioes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estados_civis_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSanguinio()
    {
        return $this->belongsTo(TipoSanguinio::class, 'tipos_sanguinios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corRaca()
    {
        return $this->belongsTo(CorRaca::class, 'cores_racas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ufNascimento()
    {
        return $this->belongsTo(Estado::class, 'uf_nascimento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exame1()
    {
        return $this->belongsTo(Exame::class, 'exames1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exame2()
    {
        return $this->belongsTo(Exame::class, 'exames2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, "instituicoes_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicaoEscolar()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_escolar_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cursoSuperior()
    {
        return $this->belongsTo(CursoSuperior::class, 'cursos_superiores_id');
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataExpedicaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_expedicao']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataExpedicaoAttribute($value)
    {
        $this->attributes['data_expedicao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataNasciementoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_nasciemento']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataNasciementoAttribute($value)
    {
        $this->attributes['data_nasciemento'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataExameNacionalUmAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_exame_nacional_um']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataExameNacionalUmAttribute($value)
    {
        $this->attributes['data_exame_nacional_um'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataExameNacionalDoisAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_exame_nacional_dois']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataExameNacionalDoisAttribute($value)
    {
        $this->attributes['data_exame_nacional_dois'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aluno()
    {
        return $this->hasMany(Aluno::class);
    }
}