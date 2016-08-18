<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class PlanoEnsino extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_plano_ensino';

	protected $dates    = [
		'vigencia',
	];

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
		'ativo'
	];

    public function conteudoProgramatico()
    {
        return $this->hasMany(ConteudoProgramatico::class);
    }

    /**
     *
     * @return \DateTime
     */
    public function getVigenciaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['vigencia']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setVigenciaAttribute($value)
    {
        $this->attributes['vigencia'] = SerbinarioDateFormat::toUsa($value);
    }
}