<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ExemplarValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [
		'img' => 'Foto',
		'editoras_id' =>  'Editora' ,
		'numero_pag' =>  'Número de página' ,
		'isbn' =>  'ISBN' ,
		'arcevos_id' =>  'Acervo' ,
	];
	
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'img' => 'image|max:500',
			'editoras_id' =>  'required' ,
			'numero_pag' =>  'required' ,
			'isbn' =>  'required' ,
			'arcevos_id' =>  'required' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
			'img' => 'image|max:500',
			'editoras_id' =>  'required' ,
			'numero_pag' =>  'required' ,
			'isbn' =>  'required' ,
			'arcevos_id' =>  'required' ,
		],
   ];

}
