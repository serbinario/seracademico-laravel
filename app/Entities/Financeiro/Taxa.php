<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Semestre;
use Seracademico\Uteis\SerbinarioDateFormat;

class Taxa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * Name of the table
     *
     * @var string
     */
    protected $table    = 'fin_taxas';

    /**
     * Fields type date
     *
     * @var array
     */
    protected $dates    = [
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
        'semestre_id'
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
}