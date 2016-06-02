<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Professor extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_professores';

    protected $fillable = [ 
		'nome',
		'tratamento',
		'nome_pai',
		'nome_social',
		'nome_mae',
		'identidade',
		'orgao_rg',
		'data_expedicao',
		'cpf',
		'titulo_eleitoral',
		'zona',
		'secao',
		'resevista',
		'categoria_resevista',
		'data_nascimento',
		'nacionalidade',
		'naturalidade',
		'endereco_id',
		'sexo_id',
		'turno_id',
		'titulacao_id',
		'profissao_id',
		'religiao_id',
		'estado_civil_id',
		'tipo_sanguinio_id',
		'cor_raca_id',
		'uf_nascimento_id',
		'email',
		'telefone_fixo',
		'celular',
		'celular2',
		'deficiencia_auditiva',
		'deficiencia_visual',
		'deficiencia_fisica',
		'deficiencia_outra',
		'path_image',
		'instituicao_graduacao_id',
		'instituicao_pos_id',
		'instituicao_mestrado_id',
		'instituicao_doutorado_id',
		'especificacao_graduacao',
		'especificacao_pos',
		'especificacao_mestrado',
		'especificacao_doutorado',
		'grau_intrucao_id',
		'ctps_numero',
		'ctps_serie',
		'data_admissao'
	];

	/**
	 * @return string
	 */
	public function getDataNascimentoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_nascimento']);
	}

	/**
	 * @return string
	 */
	public function getDataAdmissaoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_admissao']);
	}

    /**
     * @return string
     */
    public function getDataExpedicaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_expedicao']);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }

    public function grauInstrucao()
    {
        return $this->belongsTo(GrauInstrucao::class, 'grau_instrucao_id');
    }

    public function profissao()
    {
        return $this->belongsTo(Profissao::class, 'profissao_id');
    }

    public function religiao()
    {
        return $this->belongsTo(Religiao::class, 'religiao_id');
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    public function tipoSanguinio()
    {
        return $this->belongsTo(TipoSanguinio::class, 'tipo_sanguinio_id');
    }

    public function corRaca()
    {
        return $this->belongsTo(CorRaca::class, 'cor_raca_id');
    }

    public function ufNascimento()
    {
        return $this->belongsTo(Estado::class, 'uf_nascimento_id');
    }

    public function instituicaoGraduacao()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_graduacao_id");
    }

    public function instituicaoPos()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_pos_id");
    }

    public function instituicaoMestrado()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_mestrado_id");
    }

    public function instituicaoDoutorado()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_doutorado_id");
    }

    public function titulacao()
    {
        return $this->belongsTo(Titulacao::class, "titulacao_id");
    }

}