<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Uteis\SerbinarioDateFormat;

class DebitoAbertoAluno extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = 'fin_debitos';

    /**
     * @var array
     */
    protected $dates    = [
        'data_vencimento'
    ];

    /**
     * @var array
     */
    protected $fillable = [ 
		'taxa_id',
		'valor_debito',
        'data_vencimento',
		'mes_referencia',
		'ano_referencia',
		'valor_desconto',
		'aluno_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function taxa()
	{
		return $this->belongsTo(Taxa::class, 'taxa_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function aluno()
	{
		return $this->belongsTo(Aluno::class, 'aluno_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function boleto()
	{
		return $this->hasOne(Boleto::class, 'debito_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function beneficios()
	{
		return $this->belongsToMany(Beneficio::class, 'fin_debitos_beneficios', 'debito_id', 'beneficio_id');
	}

    /**
     *
     * @return \DateTime
     */
    public function getDataVencimentoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_vencimento']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataVencimentoAttribute($value)
    {
        $this->attributes['data_vencimento'] = SerbinarioDateFormat::toUsa($value);
    }
}