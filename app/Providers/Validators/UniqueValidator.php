<?php

namespace Seracademico\Providers\Validators;

use Illuminate\Support\Facades\DB;

class UniqueValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        # Fazendo validações básicas
        if(count($parameters) == 6 && $value != "" && $parameters[3] != ":id") {
            $valueId = (int) $parameters[3];
            $result  = DB::table($parameters[0])
                ->where($parameters[1], $value)
                ->where($parameters[2] , "<>", $valueId)
                ->where($parameters[4], $parameters[5])->count();

            # Verificando o resultado
            if($result) {
                # Retorno
                return false;
            }


        }

        #Retorno
        return true;
    }
}