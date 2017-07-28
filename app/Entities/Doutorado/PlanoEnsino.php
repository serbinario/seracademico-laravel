<?php

namespace Seracademico\Entities\Doutorado;

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
        'bibliografia_complementar',
		'competencia',
		'aula_pratica',
		'path_plano_ensino',
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

    /**
     * @param $query
     * @param $disciplinaId
     * @param $cargaHoraria
     * @return mixed
     */
    public function scopeByDisciplinaAndCargaHoraria($query, $disciplinaId, $cargaHoraria)
    {
        return $query->where('disciplina_id', $disciplinaId)->where('carga_horaria', $cargaHoraria);
    }
}