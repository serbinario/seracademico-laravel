<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Curso;

class Arcevo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_arcevos';

    protected $fillable = [
		'assunto',
		'titulo',
		'subtitulo',
		'cutter',
		'numero_chamada',
		'tipos_acervos_id',
		'etial_autor',
		'etial_outros',
		'resumo',
		'exemplar_ref',
		'tipo_periodico',
		'colecao_id',
		'genero_id',
		'situacao_id',
		'sumario',
		'obs_geral',
		'estante_id',
		'corredor_id',
		'volume',
		'palavras_chaves',
		'cdd',
		'uso_global',
		'periodicidade',
		'link',
		'outro_cdd'
	];

	public function tipoAcervo()
	{
		return $this->belongsTo(TipoAcervo::class, 'tipos_acervos_id');
	}

	public function colecao()
	{
		return $this->belongsTo(Colecao::class, 'colecao_id');
	}

	public function genero()
	{
		return $this->belongsTo(Genero::class, 'genero_id');
	}

	public function situacao()
	{
		return $this->belongsTo(Situacao::class, 'situacao_id');
	}

	public function corredor()
	{
		return $this->belongsTo(Corredor::class, 'corredor_id');
	}

	public function estante()
	{
		return $this->belongsTo(Estante::class, 'estante_id');
	}

	public function segundaEntrada()
	{
		return $this->hasMany(SegundaEntrada::class, 'arcevos_id', 'id');
	}

	public function primeiraEntrada()
	{
		//return $this->belongsToMany(PrimeiraEntrada::class, 'primeira_entrada', "arcevos_id", "responsaveis_id")
			//->withPivot([ 'arcevos_id', 'responsaveis_id', 'id']);
		return $this->hasMany(PrimeiraEntrada::class, 'arcevos_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function cursos()
	{
		return $this->belongsToMany(Curso::class, 'bib_arcevos_cursos', 'arcevos_id', "cursos_id")
			->withPivot([ 'arcevos_id', 'cursos_id']);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function exemplares(){
		return $this->hasMany(Exemplar::class, 'arcevos_id', 'id');
	}
}