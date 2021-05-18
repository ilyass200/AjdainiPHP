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
use PDO;

class Mysql extends Driver
{
    protected function setConnection()
	{
			try
			{
                $dns = $this->dns('mysql',$_ENV['DB_NAME'],$_ENV['DB_HOST'],$_ENV['DB_PORT'],$_ENV['DB_ENCODING']);  
                $time_zone = $_ENV['time_zone'] !== NULL ? $_ENV['time_zone'] : "+".(date('Z') / 3600).":00";

				return new PDO($dns,$_ENV['DB_USER'],$_ENV['DB_PASSWORD'],
				array(
					PDO::ATTR_PERSISTENT => $_ENV['attr_persistent'],
                    PDO::ATTR_ERRMODE => ($_ENV['attr_errmode'] == true ? PDO::ERRMODE_WARNING : PDO::ERRMODE_SILENT),
                    PDO::MYSQL_ATTR_INIT_COMMAND =>"SET time_zone = '".$time_zone."'"
				));

			}
			catch(Exception $e)
			{
				die('ERROR CONNECTION : '.$e->getMessage());
			}
    }
    

}

?>