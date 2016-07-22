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
        'pessoa_id'
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

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
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

    /**
     * @param $query
     */
    public function scopeGetValues($query)
    {
        $query
            ->join('pessoas.id', '=', 'professores.pessoa_id')
            ->select([
                'professores.id',
                'pessoas.nome'
            ])
            ->get();
    }

}