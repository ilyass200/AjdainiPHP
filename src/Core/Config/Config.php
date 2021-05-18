<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AjdainiPHP\Core\Config;

/**
 * Manage your configuration files under a single class 
 * 
 * Your configuration file must return an array and only .php and .ini extensions are accepted
 */
class Config
{

    static public $arr_config_files = [];
    static protected $config_dir = ROOT.'/Config/';


    /**
     *
     * Import a Config file and store it under a unique name (ex: AddConfigFile('TestData','testdata.php'))
     *
     * @param string $config_name Name for your config file
     * @param string $dir_config_file The config file to import 
     *
     */
    static function AddConfigFile(string $config_name,string $dir_config_file)
    {
        $config_file = self::$config_dir.$dir_config_file;

        if(!file_exists($config_file))
        {
            throw new \Exception('The directory of your config file was not found ! path("'.$dir_config_file.'")');
        }

        foreach(self::$arr_config_files as $file)
        {
            if($file['name'] === $config_name)
            {
                throw new \Exception("The name of your configuration file '".$config_name."' already exists ! please choose another name");
            }
        }
    
        if(substr($dir_config_file,-4) === ".ini")
        {
            $config_file = parse_ini_file($config_file,false,INI_SCANNER_TYPED);
        }
        else
        {
            $config_file = require_once($config_file);
        }

        self::$arr_config_files[] = ['name'=> $config_name,'dir_config_file'=> $config_file];
    }


    /**
     *
     * @param string $config_name Name stored previously that links to a config file 
     * @return array return the config file concerned
     * 
     */
    static function getConfig($config_name): array
    {
        foreach(self::$arr_config_files as $config_file)
        {
            if($config_file['name'] === $config_name)
            {
               return $config_file['dir_config_file']; 
            }
        }

        throw new \Exception("the configuration file '".$config_name."' was not found on the ".ROOT."/src/Config directory !");
        
    }

    /**
     *
     * @return array return all stored config files 
     * 
     */
    static function getAll(): array
    {
        return self::$arr_config_files;
    }

}

?>