<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class EmprestimoExemplarValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'emprestimo_id' =>  '' ,
			'exemplar_id' =>  '' ,
			'taxa_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'emprestimo_id' =>  '' ,
			'exemplar_id' =>  '' ,
			'taxa_id' =>  '' ,

        ],
   ];

}
