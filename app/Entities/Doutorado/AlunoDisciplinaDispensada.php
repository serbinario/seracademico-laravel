<?php

namespace Seracademico\Entities\Doutorado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Motivo;
use Seracademico\Entities\Instituicao;
use Seracademico\Uteis\SerbinarioDateFormat;

class AlunoDisciplinaDispensada extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_alunos_dispensadas';

    protected $dates    = [
        'data'
    ];

    protected $fillable = [ 
		'disciplina_id',
		'pos_aluno_curso_id',
        'instituicao_id',
		'motivo_id',
		'nota_final',
		'carga_horaria',
		'data',
		'qtd_credito',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function disciplina()
	{
		return $this->belongsTo(Disciplina::class, 'disciplina_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function motivo()
	{
		return $this->belongsTo(Motivo::class, 'motivo_id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, 'instituicao_id');
    }

    /**
     * @return \DateTime
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     * @return \DateTime
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }
}