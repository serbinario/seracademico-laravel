<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoDocumento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_tipos_documentos_alunos';

    protected $fillable = [ 
		'nome',
        'tipo_nivel_mestrado_id'
	];

    public function scopeNivelDeGraduacao($query)
    {
        return $query->where('tipo_nivel_sistema_id', 1);
    }

}