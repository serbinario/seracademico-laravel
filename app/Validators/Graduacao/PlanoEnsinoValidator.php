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
            
			'nome' =>  'unique:fac_plano_ensino,nome,:id,id,carga_horaria,:ch' ,
			//'nome' =>  'unique:fac_plano_ensino,carga_horaria,10,id,nome,"teste1"' ,
			//unique:users,username,10,id,company_id,31
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
			'conteudo_programatico' => ''

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
