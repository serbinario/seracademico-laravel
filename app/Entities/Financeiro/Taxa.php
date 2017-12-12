<?php
namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Semestre;
use Seracademico\Entities\Graduacao\VestibulandoFinanceiro;
use Seracademico\Entities\Graduacao\Vestibular;
use Seracademico\Uteis\SerbinarioDateFormat;

class Taxa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * Name of the table
     *
     * @var string
     */
    protected $table = 'fin_taxas';

    /**
     * Fields type date
     *
     * @var array
     */
    protected $dates = [
        'valido_inicio',
        'valido_fim'
    ];

    /**
     * Fields for MassAssigment
     *
     * @var array
     */
    protected $fillable = [ 
		'codigo',
		'nome',
        'valor',
        'tipo_taxa_id',
        'dia_vencimento',
        'valido_inicio',
        'valido_fim',
        'banco_id',
        'tipo_debito_id',
        'semestre_id',
        'exigencia_financeiro_id',
        'exigencia_biblioteca_id',
        'exigencia_evento_id',
        'exigencia_calendario_id',
        'tipo_multa_id',
        'tipo_juro_id',
        'valor_multa',
        'valor_juros',
        'alterar_data_vencimento',
        'tipo_nivel_sistema_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoTaxa()
    {
        return $this->belongsTo(TipoTaxa::class, 'tipo_taxa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function beneficios()
    {
        return $this->belongsToMany(Beneficio::class, 'fin_beneficios_taxas', 'taxa_id', 'beneficio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debitos()
    {
        return $this->hasMany(Debito::class, 'taxa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debitosVestibulandos()
    {
        return $this->hasMany(VestibulandoFinanceiro::class, 'taxa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vestibulares()
    {
        return $this->hasMany(Vestibular::class, 'taxa_id');
    }

    /**
     *
     * @return \DateTime
     */
    public function setValidoInicioAttribute($value)
    {
        $this->attributes['valido_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getValidoInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_inicio']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setValidoFimAttribute($value)
    {
        $this->attributes['valido_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     *
     * @return \DateTime
     */
    public function getValidoFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['valido_fim']);
    }

    /**
     * @param $query
     * @param $idBeneficio
     * @return mixed
     */
    public function scopeNotBeneficio($query, $idBeneficio)
    {
        return $query
            ->select(['fin_taxas.id', 'fin_taxas.nome', 'fin_taxas.codigo'])
            ->whereNotIn('fin_taxas.id', function ($query) use ($idBeneficio) {
                $query->from('fin_beneficios_taxas')
                    ->select('fin_beneficios_taxas.taxa_id')
                    ->where('fin_beneficios_taxas.beneficio_id', $idBeneficio)->get();
            });
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeTaxaByBiblioteca($query, $value)
    {
        return $query
            ->select(['id', 'nome'])
            ->whereIn('id', [15,16]);
    }

    /**
     * @param $query
     * @param $idNivel
     * @return mixed
     */
    public function scopeByNivel($query, $idNivel)
    {
        return $query->where('tipo_nivel_sistema_id', $idNivel);
    }
}