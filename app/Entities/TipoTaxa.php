<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class TipoTaxa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'tipos_taxas';

    protected $fillable = [
		'nome'
	];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithTaxas($query)
    {
        return $query->select(['tipos_taxas.id', 'tipos_taxas.nome'])
            ->join('taxas', 'taxas.tipo_taxa_id', '=', 'tipos_taxas.id');
    }
}