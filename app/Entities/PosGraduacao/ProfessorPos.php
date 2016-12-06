<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Instituicao;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\Titulacao;
use Seracademico\Entities\Turno;
use Seracademico\Uteis\SerbinarioDateFormat;

class ProfessorPos extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_professores';

    /**
     * @var array
     */
    protected $dates    = [
        'data_admissao'
    ];

    protected $fillable = [
		'tratamento',
		'turno_id',
		'titulacao_id',
		'path_image',
		'instituicao_graduacao_id',
		'instituicao_pos_id',
		'instituicao_mestrado_id',
		'instituicao_doutorado_id',
		'especificacao_graduacao',
		'especificacao_pos',
		'especificacao_mestrado',
		'especificacao_doutorado',
		'ctps_numero',
		'ctps_serie',
		'data_admissao',
        'pis',
        'pessoa_id',
        'tipo_nivel_sistema_id',
        'pos_e_graduacao',
        'path_anexo',
        'curriculo_lattes_doc_obrigatorio',
        'diploma_graduacao_obrigatorio',
        'diploma_pos_obrigatorio',
        'diploma_mestrado_obrigatorio',
        'diploma_doutorado_obrigatorio'
	];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }
    
	/**
	 * @return string
	 */
	public function getDataAdmissaoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_admissao']);
	}

    /**
     *
     * @return \DateTime
     */
    public function setDataAdmissaoAttribute($value)
    {
        $this->attributes['data_admissao'] = SerbinarioDateFormat::toUsa($value);
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
    public function instituicaoGraduacao()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_graduacao_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicaoPos()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_pos_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicaoMestrado()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_mestrado_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicaoDoutorado()
    {
        return $this->belongsTo(Instituicao::class, "instituicao_doutorado_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function titulacao()
    {
        return $this->belongsTo(Titulacao::class, "titulacao_id");
    }

    /**
     * @param $query
     */
    public function scopeGetValues($query)
    {
        $query
            ->join('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
            ->select([
                'fac_professores.id',
                'pessoas.nome'
            ]);
    }

}