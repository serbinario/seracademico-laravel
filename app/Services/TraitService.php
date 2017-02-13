<?php
namespace Seracademico\Services;


trait TraitService
{
    /**
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    if(is_array($value2)) {
                        foreach ($value2 as $key3 => $value3) {
                            $explodeKey3 = explode("_", $key3);

                            if ($explodeKey3[count($explodeKey3) -1] == "id" && !$value3 ) {
                                unset($data[$key][$key2][$key3]);
                            }
                        }
                    } else {
                        $explodeKey2 = explode("_", $key2);

                        if ($explodeKey2[count($explodeKey2) -1] == "id" && !$value2 ) {
                            unset($data[$key][$key2]);
                        }
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && !$value ) {
                unset($data[$key]);
            }
        }

        #Retorno
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoImagem(array &$data, $aluno = "")
    {
        # Recuperando dados da imagem
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Query de atualização
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$aluno->id} ";

            # Persistindo as alterações
            $pdo->query($query);
        } else if ($img && !$imgCam) {
            # Inserindo a imagem
            $this->insertImg($aluno->id, 1);
        } else if ($imgCam && $img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Query de atualização
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$aluno->id} ";

            # Persistindo as alterações
            $pdo->query($query);
        }
    }

    /**
     * @param $id
     */
    public function insertImg($id, $tipo)
    {
        #tratando a imagem
        if(isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {
            # Tratando a imagem
            $tmpName = $_FILES['img']['tmp_name'];
            $fp = fopen($tmpName, 'r');
            $add = fread($fp, filesize($tmpName));

            # Escapando os caractéres
            $add = addslashes($add);

            # Fechando o arquivo
            fclose($fp);

            # Persistindo no banco
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE pos_alunos SET path_image = '{$add}', tipo_img = {$tipo} where id =  $id ";
            $pdo->query($query);
        }

    }
}