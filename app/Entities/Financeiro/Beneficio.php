<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Uteis\SerbinarioDateFormat;

class Beneficio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_beneficios';

    protected $dates    = [
        'data_inicio',
        'data_fim'
    ];

    protected $fillable = [
        'codigo',
		'data_inicio',
		'data_fim',
		'valor',
		'tipo_beneficio_id',
		'aluno_id',
        'tipo_id',
        'incidencia_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoValor()
    {
        return $this->belongsTo(TipoValor::class, 'tipo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoBeneficio()
    {
        return $this->belongsTo(TipoBeneficio::class, 'tipo_beneficio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxas()
    {
        return $this->belongsToMany(Taxa::class, 'fin_beneficios_taxas', 'beneficio_id', 'taxa_id');
    }

    /**
     * @return string
     */
    public function getDataInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inicio']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataInicioAttribute($value)
    {
        $this->attributes['data_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_fim']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataFimAttribute($value)
    {
        $this->attributes['data_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @param $query
     * @param $idTaxa
     * @return mixed
     */
    public function scopeByTaxa($query, $idTaxa)
    {
        return $query
            ->join('fin_tipos_beneficios', 'fin_tipos_beneficios.id', '=', 'fin_beneficios.tipo_beneficio_id')
            ->join('fin_beneficios_taxas', 'fin_beneficios_taxas.beneficio_id', '=', 'fin_beneficios.id')
            ->where('fin_beneficios_taxas.taxa_id', $idTaxa)
            ->select([
                'fin_beneficios.id',
                'fin_beneficios.codigo',
                'fin_tipos_beneficios.nome'
            ]);
    }
}