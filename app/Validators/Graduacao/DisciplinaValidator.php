<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class DisciplinaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [

	];

	protected $attributes = [
		'nome' => 'Nome',
		'codigo' => 'Código'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  'required|max:200|unique:fac_disciplinas,nome',
			'codigo' => 'required|max:15|unique:fac_disciplinas,codigo,NULL,NULL,tipo_nivel_sistema_id,1',
			'carga_horaria' => 'digits_between:1,5|numeric' ,
			'carga_horaria_teorica' => 'digits_between:1,5|numeric' ,
			'carga_horaria_pratica' => 'digits_between:1,5|numeric' ,
			'qtd_credito' =>  'numeric' ,
			'qtd_falta' =>  'numeric' ,
			'tipo_disciplina_id' =>  'integer' ,
			'tipo_avaliacao_id' =>  'integer' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:200|unique:fac_disciplinas,nome,:id',
			'codigo' => 'required|max:15|unique:fac_disciplinas,codigo,:id,id,tipo_nivel_sistema_id,1',
			'carga_horaria' => 'digits_between:1,5|numeric' ,
			'carga_horaria_teorica' => 'digits_between:1,5|numeric' ,
			'carga_horaria_pratica' => 'digits_between:1,5|numeric' ,
			'qtd_credito' =>  'numeric' ,
			'qtd_falta' =>  'numeric' ,
			'tipo_disciplina_id' =>  'integer' ,
			'tipo_avaliacao_id' =>  'integer' ,
		],
   ];

}
