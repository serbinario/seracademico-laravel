<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class DiarioAula extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_diarios_aulas';

    protected $dates    = [
        'data'
    ];

    protected $fillable = [ 
		'data',
		'numero_aula',
		'hora_inicial',
		'hora_final',
		'carga_horaria',
        'turma_disciplina_id',
        'professor_id',
        'assunto_ministrado'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conteudos()
    {
        return $this->belongsToMany(ConteudoProgramatico::class,
            'fac_diarios_aulas_conteudos_programaticos', 'diario_aula_id', 'conteudo_programatico_id');
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($diario) {
            $diario->conteudos()->detach();
            // do the rest of the cleanup...
        });
    }
}