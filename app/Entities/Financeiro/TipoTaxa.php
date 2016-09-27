<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class TipoTaxa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipos_taxas';

    protected $fillable = [
		'nome'
	];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithTaxas($query)
    {
        return $query
            ->distinct()
            ->select(['fin_tipos_taxas.id', 'fin_tipos_taxas.nome'])
            ->join('fin_taxas', 'fin_taxas.tipo_taxa_id', '=', 'fin_tipos_taxas.id');
    }
}