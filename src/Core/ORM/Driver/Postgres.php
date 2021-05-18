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

class Postgres extends Driver
{
    protected function setConnection()
	{
			try
			{
                $dsn = $this->dns('pgsql',$_ENV['DB_NAME'],$_ENV['DB_HOST'],$_ENV['DB_PORT'],$_ENV['DB_ENCODING']);  
                $time_zone = ($_ENV['time_zone']) ? $_ENV['time_zone'] : "+".(date('Z') / 3600).":00";

                $options = array(
					PDO::ATTR_PERSISTENT => $_ENV['attr_persistent'],
                    PDO::ATTR_PERSISTENT => ($_ENV['attr_errmode'] == true ? PDO::ATTR_ERRMODE : PDO::ERRMODE_SILENT),
                    PDO::MYSQL_ATTR_INIT_COMMAND =>"SET timezone = ".$time_zone	
				);

				$pdo = new PDO($dsn,$_ENV['DB_USER'],$_ENV['DB_PASSWORD'],$options);

                if($_ENV['schema'] !== NULL)
                {
                    $dpo->exec('SET search_path TO '.$_ENV['schema']);
                }

                return $dpo;

			}
			catch(Exception $e)
			{
				die('ERROR CONNECTION : '.$e->getMessage());
			}
    }

    public function newSchema(string $schema)
    {
        $this->getConnection()->exec('SET search_path = '.$schema);
    }
    
    

}

?>