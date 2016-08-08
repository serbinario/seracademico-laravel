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

            'nome' =>  'required|max:200|unique:fac_materias,nome',
            'codigo' =>  'required|max:15|unique:fac_materias,codigo',
			'anotacao' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

            'nome' =>  'required|max:200|unique:fac_materias,nome,:id',
            'codigo' =>  'required|max:15|unique:fac_materias,codigo,:id',
			'anotacao' =>  '' ,

        ],
   ];

}
