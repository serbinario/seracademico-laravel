<?php


namespace Serbinario\L5scaffold\Util;

use Illuminate\Support\Facades\DB;
use PDO;

Class Tables
{

    private $fieldsTables;

    private  $tables;

    private $fieldsArray = array();

    private $tablessArray = array();

    private static $nameClasseSingular;

    private static $database = "";

    private static $dirProject;

    private static $pathFile;

    private static $selects = array('column_name as Field', 'column_type as Type', 'is_nullable as Null', 'column_key as Key', 'column_default as Default', 'extra as Extra', 'data_type as Data_Type');


    /**
     * @param $pathFile
     * Caminho do arquivo a ser gerado ex: /app/Models
     */
    public static function setPathFile($pathFile)
    {
        self::$pathFile = $pathFile;
    }

    /**
     * @param $database
     * Banco de dados do projetos a ser gerado
     */
    public static function setDatabase($database)
    {
        self::$database = $database;
    }

    /**
     * @param $dirProject
     * Diretório do projeto, o nome é case sensitive
     */
    public static function setDirProject($dirProject)
    {
        self::$dirProject = $dirProject;
    }

    public static function  getDirProject()
    {
        return self::$dirProject;
    }
    /**
     *
     */
    public static function getTables()
    {
        $tablesArray = array();
        //return DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema="' . self::$database . '"');
        $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema="' . self::$database . '"');
        foreach ($tables as  $value)
        {
            array_push($tablesArray, $value->table_name);
        }
        return $tablesArray;

    }

    public static function getTableDescribes($table)
    {
        return DB::table('information_schema.columns')
            ->where('table_schema', '=', self::$database)
            ->where('table_name', '=', $table)
            ->get(self::$selects);
    }

    public static function getForeignTables()
    {
        dd(self::$database);
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('CONSTRAINT_SCHEMA', '=', self::$database)
            ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
            ->select('TABLE_NAME')->distinct()
            ->get();
    }

    public static function getForeigns($table)
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('CONSTRAINT_SCHEMA', '=', self::$database)
            ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
            ->where('TABLE_NAME', '=', $table)
            ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
            ->get();
    }

    /**
     * @param null $compileRelations
     */
    public static function write($compileModel)
    {
        $schema = $compileModel;
        $path = "../" .  self::$dirProject . self::$pathFile . self::$nameClasseSingular . ".php";
        self::$nameClasseSingular = "";
        Generic::saveTo($path, $schema);
    }


    public static function ucWords($nameClass)
    {
        //Se o da tabela veio com um anderline
        if(strstr($nameClass,"_"))
        {
            $nameClass = explode("_", $nameClass);
            foreach($nameClass as $nc)
            {
                self::$nameClasseSingular .= ucfirst(Inflector::singularize($nc));
            }
            //dd($this->nameClasseSingular);
        }else{
            self::$nameClasseSingular = ucfirst(Inflector::singularize($nameClass));
        }
        //dd($this->nameClasseSingular);
        return self::$nameClasseSingular;
    }


    public static function compileRelations($v, $nome_classe, $name_space)
    {
        $relacionamento  = "\n\tpublic function " . strtolower($nome_classe) . "()\n";
        $relacionamento .= "\t{\n";
        $relacionamento .= "\t\treturn \$this->belongsTo('$name_space\Models\\" . $nome_classe  . "' );\n";
        $relacionamento .= "\n\t}";

        return  $relacionamento;

    }


}