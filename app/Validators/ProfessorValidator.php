<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProfessorValidator extends LaravelValidator
{
	protected $messages = [];

	protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'tratamento' =>  '' ,
			'nome_pai' =>  '' ,
			'nome_social' =>  '' ,
			'nome_mae' =>  '' ,
			'identidade' =>  '' ,
			'orgao_rg' =>  '' ,
			'data_expedicao' =>  '' ,
			'cpf' =>  '' ,
			'titulo_eleitoral' =>  '' ,
			'zona' =>  '' ,
			'secao' =>  '' ,
			'resevista' =>  '' ,
			'categoria_resevista' =>  '' ,
			'data_nascimento' =>  '' ,
			'nacionalidade' =>  '' ,
			'naturalidade' =>  '' ,
			'endereco_id' =>  '' ,
			'sexo_id' =>  '' ,
			'turno_id' =>  '' ,
			'grau_instrucao_id' =>  '' ,
			'profissao_id' =>  '' ,
			'religiao_id' =>  '' ,
			'estado_civil_id' =>  '' ,
			'tipo_sanguinio_id' =>  '' ,
			'cor_raca_id' =>  '' ,
			'uf_nascimento_id' =>  '' ,
			'email' =>  '' ,
			'telefone_fixo' =>  '' ,
			'celular' =>  '' ,
			'celular2' =>  '' ,
			'deficiencia_auditiva' =>  '' ,
			'deficiencia_visual' =>  '' ,
			'deficiencia_fisica' =>  '' ,
			'deficiencia_outra' =>  '' ,
			'path_image' =>  '' ,
			'instituicao_graduacao_id' =>  '' ,
			'instituicao_pos_id' =>  '' ,
			'instituicao_mestrado_id' =>  '' ,
			'instituicao_doutorado_id' =>  '' ,
			'especificacao_graduacao' =>  '' ,
			'especificacao_pos' =>  '' ,
			'especificacao_mestrado' =>  '' ,
			'especificacao_doutorado' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
