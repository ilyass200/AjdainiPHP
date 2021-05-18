<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace AjdainiPHP\Core\ORM\Table;
use AjdainiPHP\Entity\UsersEntity;
use AjdainiPHP\Core\Entity\Entity;
use AjdainiPHP\Core\ORM\Table\CRUDtrait;

class Table
{
    use CRUDtrait;
    protected $pdo = NULL;
    protected $drivers = ['mysql','postgres'];
    protected $entity = "";
    protected $table = "";
    protected $db = "";
    protected $primary_key = '';

    function __construct()
    {
        if(!in_array($_ENV['DB_DRIVER'],$this->drivers))
        {
            throw new \Exception('Oops, the "'.$_ENV['DB_DRIVER'].'" driver is not available at the moment! Here are the currently available drivers : ' .implode(', ',$this->drivers) );
        }

        $driver = 'AjdainiPHP\Core\ORM\Driver\\'.ucfirst($_ENV['DB_DRIVER']);

        $this->pdo = new $driver();
        $this->db = $_ENV['DB_NAME'];  
    }

    public function getConnection()
    {
        return $this->pdo->getConnection();
    }

    public function getEntity()
    {
        if(!$this->entity)
        {
            $entity = 'AjdainiPHP\Entity\\'.$this->DefaultEntity();
            return new $entity();
        } 
        else
        {
            $entity = 'AjdainiPHP\Entity\\'.$this->entity;
            return new $entity();
        }
    }
    
    public function setPrimaryKey(string $key)
    {
        $this->primary_key = $key;
    }

    public function setTableName(string $table)
    {
        $this->table = $table;
    }

    public function getTableName()
    {
        return ($this->table) ? $this->table : $this->DefaultTable(); 
    }

    public function setEntityName(string $entity)
    {
        $this->entity = $entity."Entity";
    }

    public function getEntityName()
    {
        return ($this->entity) ? $this->entity : $this->DefaultEntity(); 
    }

    public function getEntityNamespace()
    {
        return 'AjdainiPHP\Entity\\'.$this->getEntityName();
    }

    protected function DefaultEntity()
    {
        $class = explode('\\',get_called_class());
        $class = end($class);
        return str_replace('Table','',$class).'Entity';       
    }
    
    protected function DefaultTable()
    {
        $class = explode('\\',get_called_class());
        $class = end($class);
        return strtolower(str_replace('Table','',$class));        
    }
    
}

?>