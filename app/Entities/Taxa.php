<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Taxa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'taxas';

    protected $fillable = [ 
		'codigo',
		'nome',
        'valor',
        'tipo_taxa_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoTaxa()
    {
        return $this->belongsTo(TipoTaxa::class, 'tipo_taxa_id');
    }
}