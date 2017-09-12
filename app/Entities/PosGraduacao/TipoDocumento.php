<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public function scopeNivelDePosGraduacao($query)
    {
        $queryResult = $query->where('tipo_nivel_sistema_id', 2);

        if(Auth::user()->sede_id != 1) {
            $queryResult->whereIn('nome', ['FICHA INSCRIÇÃO', 'DECLARAÇÃO VÍNCULO MODELO']);
        }

        return $queryResult;
    }

}