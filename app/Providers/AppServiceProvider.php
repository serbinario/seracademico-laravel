<?php

namespace Seracademico\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('serbinario_date_format', function($attribute, $value, $formats, $validator) {

            #Verificando se o valor já é uma data
            if($value instanceof \DateTime) {
                return true;
            }

            #Convertendo a data
            $parsed = date_parse_from_format($formats[0], $value);

            #Verificando se houve erro de conversão
            if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                return true;
            }

            #retorno
            return false;
        });

        Validator::extend('serbinario_alpha_space', function($attribute, $value, $formats, $validator) {
            #expressão regular
            $pattern = "/^[\pL\s\-]+$/u";

            #Validando pela expressão regular
            if (\preg_match($pattern, $value)) {
                return true;
            }

            #retorno
            return false;
        });

        // Permitido alguns caracteres especiais . - []
        Validator::extend('serbinario_alpha_space_especial', function($attribute, $value, $formats, $validator) {
            #expressão regular
            $pattern = "/^[\d\pL\s\-\.\[\]]+$/u";

            #Validando pela expressão regular
            if (\preg_match($pattern, $value)) {
                return true;
            }

            #retorno
            return false;
        });

        // Validator para arquivo pdf
        Validator::extend('pdf', function($attribute, $value, $formats, $validator) {
            if(!is_string($value)) {
                $allowed_mimes = [
                    // 'image/jpeg', // jpeg/jpg
                    //'image/png', // png
                    // 'application/octet-stream', // txt etc
                    // 'application/msword', // doc
                    // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
                    // 'application/vnd.ms-excel', // xls
                    //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
                    'application/pdf', // pdf
                ];

                return in_array($value->getMimeType(), $allowed_mimes);
            }

            return true;
        });

        Validator::extend('serbinario_unique', '\\Seracademico\\Providers\\Validators\\UniqueValidator@validate');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
