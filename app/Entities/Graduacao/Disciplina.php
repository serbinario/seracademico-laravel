<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Curriculo;
use Seracademico\Entities\Turma;

class Disciplina extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_disciplinas';

    protected $fillable = [ 
		'nome',
        'codigo',
		'carga_horaria',
		'carga_horaria_pratica',
		'carga_horaria_teorica',
		'qtd_credito',
		'qtd_falta',
		'tipo_disciplina_id',
		'tipo_avaliacao_id',
		'tipo_nivel_sistema_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function curriculos()
	{
		return $this->belongsToMany(Curriculo::class, "fac_curriculo_disciplina", "disciplina_id", "curriculo_id");
	}

}