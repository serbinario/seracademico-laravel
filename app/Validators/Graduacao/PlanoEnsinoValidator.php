<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class PlanoEnsinoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'vigencia' =>  '' ,
			'disciplina_id' =>  '' ,
			'carga_horaria' =>  '' ,
			'conteudo_porgramatico_id' =>  '' ,
			'ementa' =>  '' ,
			'obj_gerais' =>  '' ,
			'obj_especifico' =>  '' ,
			'metodologia' =>  '' ,
			'recurso_audivisual' =>  '' ,
			'avaliacao' =>  '' ,
			'bibliografia_basica' =>  '' ,
			'competencia' =>  '' ,
			'aula_pratica' =>  '' ,
			'conteudo_programatico' => 'required'

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
			'vigencia' =>  '' ,
			'disciplina_id' =>  '' ,
			'carga_horaria' =>  '' ,
			'conteudo_porgramatico_id' =>  '' ,
			'ementa' =>  '' ,
			'obj_gerais' =>  '' ,
			'obj_especifico' =>  '' ,
			'metodologia' =>  '' ,
			'recurso_audivisual' =>  '' ,
			'avaliacao' =>  '' ,
			'bibliografia_basica' =>  '' ,
			'competencia' =>  '' ,
			'aula_pratica' =>  '' ,

        ],
   ];

}
