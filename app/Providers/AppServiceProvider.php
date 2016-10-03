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
        # Validator para formatos de datas
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

        # Validator para espaços em branco
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

        // Validator para unique em pessoa pelo aluno
        Validator::extend('graduacao_aluno_unique_in_pessoa', function($attribute, $value, $formats, $validator) {
            # Vaidando a entrada de parámetros
            if(count($formats) == 2 && $value != "" && $formats[1] != ":id") {
                # Fazendo a query
                $rows = \DB::table('pessoas')
                    ->join('fac_alunos', 'fac_alunos.pessoa_id', '=', 'pessoas.id')
                    ->where("pessoas.{$formats[0]}", $value)
                    ->where("fac_alunos.id", "!=", $formats[1])
                    ->select(['pessoas.id'])->get();

                # Verificando a quantidade de retorno
                if(count($rows) > 0) {
                    return false;
                }
            }

            #retorno
            return true;
        });

        // Validator para unique em pessoa pelo aluno de pos
        Validator::extend('pos_aluno_unique_in_pessoa', function($attribute, $value, $formats, $validator) {
            # Vaidando a entrada de parámetros
            if(count($formats) == 2 && $value != "" && $formats[1] != ":id") {
                # Fazendo a query
                $rows = \DB::table('pessoas')
                    ->join('pos_alunos', 'pos_alunos.pessoa_id', '=', 'pessoas.id')
                    ->where("pessoas.{$formats[0]}", $value)
                    ->where("pos_alunos.id", "!=", $formats[1])
                    ->select(['pessoas.id'])->get();

                # Verificando a quantidade de retorno
                if(count($rows) > 0) {
                    return false;
                }
            }

            #retorno
            return true;
        });

        // Validator para unique em pessoa
        Validator::extend('unique_in_pessoa', function($attribute, $value, $formats, $validator) {

            # Vaidando a entrada de parámetros
            if(count($formats) == 1 && $value != "") {
                # Fazendo a query
                $rows = \DB::table('pessoas')
                    ->where("pessoas.{$formats[0]}", $value)
                    ->select(['pessoas.id'])->get();

                # Verificando a quantidade de retorno
                if(count($rows) > 0) {
                    return false;
                }
            }

            #retorno
            return true;
        });

        # Unique validator
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
