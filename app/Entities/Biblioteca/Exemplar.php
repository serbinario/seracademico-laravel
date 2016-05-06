<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Exemplar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_exemplares';

    protected $fillable = [ 
		'ano',
		'registros',
		'editoras_id',
		'ilustracoes_id',
		'idiomas_id',
		'numero_pag',
		'isbn',
		'issn',
		'data_aquisicao',
		'aquisicao_id',
		'edicao',
		'editor',
		'obs_especifica',
		'exemp_principal',
		'situacao_id',
		'emprestimo_id',
		'local',
		'arcevos_id',
		'valor',
		'codigo_barra',
		'codigo',
		'path_image',
		'responsaveis_id'
	];

	public function acervo()
	{
		return $this->belongsTo(Arcevo::class, 'arcevos_id');
	}

}