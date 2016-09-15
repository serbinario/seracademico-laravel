<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Seracademico\Entities\Graduacao\TurmaDisciplina;
use Seracademico\Entities\Professor;
use Seracademico\Entities\Sala;
use Seracademico\Entities\Dia;
use Seracademico\Entities\Hora;
use Seracademico\Uteis\SerbinarioDateFormat;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class HorarioDisciplinaTurma extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = 'fac_horarios';

    /**
     * @var array
     */
    protected $fillable = [
        'sala_id',
        'hora_id',
        'professor_id',
        'turma_disciplina_id',
        'dia_id'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hora()
    {
        return $this->belongsTo(Hora::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dia()
    {
        return $this->belongsTo(Dia::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
