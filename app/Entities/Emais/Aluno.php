<?php

namespace Seracademico\Entities\Emais;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Pessoa;
use Seracademico\Uteis\SerbinarioDateFormat;

class Aluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pre_alunos";

    protected $fillable = [
        'pessoa_id',
        'turno_id',
        'tel_res',
        'tel_celular',
        'tel_outro',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class, 'pre_alunos_modalidades', 'pre_aluno_id', "pre_modalidade_id")
            ->withPivot([ 'pre_aluno_id', 'pre_modalidade_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'pre_alunos_materias', 'pre_aluno_id', "pre_materia_id")
            ->withPivot([ 'pre_aluno_id', 'pre_materia_id']);
    }
}