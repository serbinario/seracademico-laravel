<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 22/10/15
 * Time: 20:37
 */

namespace Serbinario\L5scaffold;


class Generic
{
    private static $replacementr = [];

    private static $filePath;

    private static $nameClasseSingular;

    public static function setFilePath($filePath)
    {
        self::$filePath = $filePath;
    }

    public static function getFilePath()
    {
        return self::$filePath;
    }

    /**
     * @param $path
     * @param $content
     * @return int
     */
    public static function saveTo($path, $content)
    {
        return file_put_contents($path, $content);
    }

    public static function getContents($replaces)
    {
        //dd(self::getFilePath());
        $contents = file_get_contents(self::getFilePath());

        foreach ($replaces as $search => $replace) {

            $contents = str_replace('$'.strtoupper($search).'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get stub replacements.
     *
     * @return array
     */
    public static function setReplacements($asd)
    {
        return self::$replacementr = array_merge($asd, self::$replacementr);
    }

    public static function getReplacements()
    {
        return self::$replacementr;
    }

    public static function clearReplacements()
    {
        return self::$replacementr = array();
    }

    public static function setNameClasseSingular($nameClasseSingular)
    {
        self::$nameClasseSingular = $nameClasseSingular;
    }

    //Retira do andreline
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

        }else{
            self::$nameClasseSingular = ucfirst(Inflector::singularize($nameClass));
        }
        //dd($this->nameClasseSingular);
        return self::$nameClasseSingular;
    }

    //Create file
    public static function write($compileModel, $phathModels, $concatClassName = null)
    {
        $schema = $compileModel;

        $path = base_path() . "/" . $phathModels . "/" . self::$nameClasseSingular . $concatClassName . ".php";
        //dd($path);
        self::$nameClasseSingular = "";
        //dd($path);
        self::saveTo($path, $schema);
    }

    public static function appendToEndOfFile($path, $text, $remove_last_chars = 0, $dont_add_if_exist = false) {
        $content = file_get_contents($path);
        //dd(strlen($content));
        if(!str_contains($content, $text) || !$dont_add_if_exist) {
            $newcontent = substr($content, 0, strlen($content)-$remove_last_chars).$text;
            file_put_contents($path, $newcontent);
        }
    }

}