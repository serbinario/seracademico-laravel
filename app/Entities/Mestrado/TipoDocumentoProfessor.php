<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoDocumentoProfessor extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'mes_tipos_documentos_professores';

    protected $fillable = [ 
		'nome',
        'tipo_nivel_mestrado_id',
	];

    public function scopeNivelDeMestrado($query)
    {
        return $query->where('tipo_nivel_sistema_id', 3);
    }

}