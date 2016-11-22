<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ExemplarPeriodicoValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [
		'img' => 'Foto',
		'editoras_id' =>  'Editora' ,
		'numero_pag' =>  'Número de página' ,
		'issn' =>  'ISSN' ,
		'arcevos_id' =>  'Acervo' ,
		'assunto_p' =>  'Assunto' ,
	];
	
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'img' => 'image|max:500',
			'editoras_id' =>  'required' ,
			'numero_pag' =>  'required' ,
			'issn' =>  'required' ,
			'arcevos_id' =>  'required' ,
			'assunto_p' =>  'required' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
			'img' => 'image|max:500',
			'editoras_id' =>  'required' ,
			'numero_pag' =>  'required' ,
			'issn' =>  'required' ,
			'arcevos_id' =>  'required' ,
			'assunto_p' =>  'required' ,
		],
   ];

}
