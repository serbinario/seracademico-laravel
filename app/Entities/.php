<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pessoa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pessoas';

    protected $fillable = [ 
		'nome',
		'nome_pai',
		'nome_social',
		'nome_mae',
		'identidade',
		'orgao_rg',
		'data_expedicao',
		'cpf',
		'titulo_eleitoral',
		'zona',
		'secao',
		'resevista',
		'catagoria_resevista',
		'data_nasciemento',
		'nacionalidade',
		'naturalidade',
		'instituicoes_id',
		'ano_conclusao_superior',
		'outra_instituicao',
		'data_exame_nacional_um',
		'nota_exame_nacional_um',
		'data_exame_nacional_dois',
		'nota_exame_nacional_dois',
		'enderecos_id',
		'sexos_id',
		'turnos_id',
		'grau_instrucoes_id',
		'profissoes_id',
		'religioes_id',
		'estados_civis_id',
		'tipos_sanguinios_id',
		'cores_racas_id',
		'exames1_id',
		'exames2_id',
		'uf_nascimento_id',
		'email',
		'telefone_fixo',
		'celular',
		'celular2',
		'deficiencia_auditiva',
		'deficiencia_visual',
		'deficiencia_fisica',
		'deficiencia_outra',
		'cursos_superiores_id',
		'path_image',
		'rg_doc_obrigatorio',
		'cpf_doc_obrigatorio',
		'certidao_nasc_cas_doc_obrigatorio',
		'titulo_eleitor_doc_obrigatorio',
		'reservista_doc_obrigatorio',
		'diploma_doc_obrigatorio',
		'fotos_3x4_doc_obrigatorio',
		'comp_residencia_doc_obrigatorio',
		'histo_gradu_autentic_obrigatorio',
		'ativo',
		'instituicao_escolar_id',
		'ano_conclusao_medio',
		'outra_escola',
	];

}