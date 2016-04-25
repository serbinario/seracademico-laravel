<?php

namespace Seracademico\Entities;

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
		'data_catagolacao',
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
	];

}