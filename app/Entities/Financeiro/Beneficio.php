<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Aluno;

class Beneficio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_beneficios';

    protected $fillable = [ 
		'data_inicio',
		'data_fim',
		'valor',
		'tipo_beneficio_id',
		'aluno_id',
	];

	public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    public function tipoBeneficio()
    {
        //return $this->belongsTo(TipoBeneficio::class, 'tipo_beneficio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxas()
    {
        return $this->belongsToMany(Taxa::class, 'fin_beneficios_taxas', 'beneficio_id', 'taxa_id');
    }
}