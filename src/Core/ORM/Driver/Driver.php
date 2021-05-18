<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace AjdainiPHP\Core\ORM\Driver;

abstract class Driver
{
    protected $PDO = NULL;    

    abstract protected function setConnection();
        
    public function getConnection()
    {
        if (!$this->PDO) 
        {
            $this->PDO = $this->setConnection();
        }

        return $this->PDO;
            
    }

    protected function dns($driver,$db_name,$host,$port,$encoding)
    {
        return "$driver:host=$host;dbname=$db_name;port=$port;charset=$encoding";
    }

    public function exec(string $sql)
    {
        $this->getConnection()->exec($sql);
    }


}


?>