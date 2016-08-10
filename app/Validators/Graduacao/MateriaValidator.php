<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class MateriaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
        
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'nome' =>  'required|max.string:60|unique:fac_materias,nome',
            'codigo' =>  'required|max:8|unique:fac_materias,codigo',
			'anotacao' =>  'max:500' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

            'nome' =>  'required|max:60|string|unique:fac_materias,nome,:id',
            'codigo' =>  'required|max:8|unique:fac_materias,codigo,:id',
			'anotacao' =>  'max:500' ,

        ],
   ];

}
