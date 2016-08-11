<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PlanoEnsino extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_plano_ensino';

    protected $fillable = [ 
		'nome',
		'vigencia',
		'disciplina_id',
		'carga_horaria',
		'conteudo_porgramatico_id',
		'ementa',
		'obj_gerais',
		'obj_especifico',
		'metodologia',
		'recurso_audivisual',
		'avaliacao',
		'bibliografia_basica',
		'competencia',
		'aula_pratica',
	];

    public function conteudoProgramatico()
    {
        return $this->hasMany(ConteudoProgramatico::class);
    }	
}