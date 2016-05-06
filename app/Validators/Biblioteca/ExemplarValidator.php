<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ExemplarValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'ano' =>  '' ,
			'registros' =>  'required' ,
			'editoras_id' =>  '' ,
			'ilustracoes_id' =>  '' ,
			'idiomas_id' =>  '' ,
			'numero_pag' =>  '' ,
			'isbn' =>  '' ,
			'issn' =>  '' ,
			'data_aquisicao' =>  '' ,
			'aquisicao_id' =>  '' ,
			'edicao' =>  '' ,
			'editor' =>  '' ,
			'obs_especifica' =>  '' ,
			'exemp_principal' =>  '' ,
			'situacao_id' =>  '' ,
			'emprestimo_id' =>  '' ,
			'local' =>  '' ,
			'arcevos_id' =>  '' ,
			'valor' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
