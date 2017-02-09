<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\TipoCurso;
use Seracademico\Repositories\Graduacao\PrecoCursoRepository;
use Seracademico\Uteis\SerbinarioDateFormat;

class Curso extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fac_cursos';

    protected $dates = [
        'data_decreto_rec',
        'data_dou_rec',
        'data_decreto_aut',
        'data_dou_aut',
        'data_matricula_inicio',
        'data_matricula_fim',
        'inicio_aula',
        'fim_aula',
        'vencimento_inicial'
    ];

    protected $fillable = [
        'nome',
        'codigo',
        'portaria_mec_rec',
        'numero_decreto_rec',
        'data_decreto_rec',
        'data_dou_rec',
        'portaria_mec_aut',
        'numero_decreto_aut',
        'data_decreto_aut',
        'data_dou_aut',
        'data_matricula_inicio',
        'data_matricula_fim',
        'inicio_aula',
        'fim_aula',
        'maximo_vagas',
        'minimo_vagas',
        'obs_vagas',
        'valor',
        'parcelas',
        'vencimento_inicial',
        'tipo_curso_id',
        'cordenador_id',
        'tipo_nivel_sistema_id',
        'carga_horaria',
        'ativo',
        'coordenador_id'
    ];

//    /*
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function curriculos()
//    {
//        return $this->hasMany(Curriculo::class);
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoCurso()
    {
        return $this->belongsTo(TipoCurso::class, "tipo_curso_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function precosCursos()
    {
        return $this->hasMany(PrecoCurso::class, "curso_id", "id");
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataDecretoRecAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_decreto_rec']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataDecretoRecAttribute($value)
    {
        $this->attributes['data_decreto_rec'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataDouRecAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_dou_rec']);
    }

    /**
     * @return \DateTime
     */
    public function setDataDouRecAttribute($value)
    {
        $this->attributes['data_dou_rec'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataDecretoAutAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_decreto_aut']);
    }

    /**
     * @return \DateTime
     */
    public function setDataDecretoAutAttribute($value)
    {
        $this->attributes['data_decreto_aut'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataDouAutAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_dou_aut']);
    }

    /**
     * @return \DateTime
     */
    public function setDataDouAutAttribute($value)
    {
        $this->attributes['data_dou_aut'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataMatriculaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_matricula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function setDataMatriculaInicioAttribute($value)
    {
        $this->attributes['data_matricula_inicio'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getDataMatriculaFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_matricula_fim']);
    }

    /**
     * @return \DateTime
     */
    public function setDataMatriculaFimAttribute($value)
    {
        $this->attributes['data_matricula_fim'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getInicioAulaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['inicio_aula']);
    }

    /**
     * @return \DateTime
     */
    public function setInicioAulaAttribute($value)
    {
        $this->attributes['inicio_aula'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getFimAulaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['fim_aula']);
    }

    /**
     * @return \DateTime
     */
    public function setFimAulaAttribute($value)
    {
        $this->attributes['fim_aula'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getVencimentoInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['vencimento_inicial']);
    }

    /**
     * @return \DateTime
     */
    public function setVencimentoInicialAttribute($value)
    {
        $this->attributes['vencimento_inicial'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeByCurriculoAtivo($query, $value)
    {
        return $query->select('fac_cursos.nome', 'fac_cursos.id')
            ->join('fac_curriculos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('fac_cursos.tipo_nivel_sistema_id', 2)
            ->where("fac_cursos.ativo", $value)
            ->where('fac_curriculos.ativo', $value);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAtivo($query, $value)
    {
        return $query->where('tipo_nivel_sistema_id', 2)->where("ativo", $value);
    }
}