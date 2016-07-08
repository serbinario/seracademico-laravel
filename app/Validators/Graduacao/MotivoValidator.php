<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class MotivoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nome' =>  'required|max:200|unique:fac_motivos,nome',
            'codigo' =>  'required|max:15|unique:fac_motivos,codigo',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' =>  'required|max:200|unique:fac_motivos,nome,:id',
            'codigo' =>  'required|max:15|unique:fac_motivos,codigo,:id',
        ],
   ];

}