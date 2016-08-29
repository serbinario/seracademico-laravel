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
		'responsaveis_id',
		'num_periodico',
		'assunto_p',
		'palavras_chaves',
		'artigos',
		'ampliada',
		'revisada',
		'atualizada',
		'vol_periodico',
		'link',
	];

	public function acervo()
	{
		return $this->belongsTo(Arcevo::class, 'arcevos_id');
	}

	public function idioma()
	{
		return $this->belongsTo(Idioma::class, 'idiomas_id');
	}

	public function editora()
	{
		return $this->belongsTo(Editora::class, 'editoras_id');
	}

	public function ilustracoes()
	{
		return $this->belongsTo(Ilustracao::class, 'ilustracoes_id');
	}

	public function aquisicao()
	{
		return $this->belongsTo(Aquisicao::class, 'aquisicao_id');
	}

	public function situacao()
	{
		return $this->belongsTo(Situacao::class, 'situacao_id');
	}

	public function emprestimo()
	{
		return $this->belongsTo(Editora::class, 'emprestimo_id');
	}

	public function editor()
	{
		return $this->belongsTo(Responsavel::class, 'responsaveis_id');
	}
}