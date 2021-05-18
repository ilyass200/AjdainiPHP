<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AjdainiPHP\Core\Database;
use AjdainiPHP\Core\Entity\Entity;

/**
 * Connect to your database and send queries in a simplistic way 
 * 
 * You must first fill in the variable fields of the .env file to have access to your database automatically
 */
class Database 
{
	protected $PDO = NULL;
	protected $CONFIG = NULL;
	protected $ERRMODE_EXCEPTION = true;

	/**
    * @return object Get the PDO class with the values of the variables you had already predefined
    */
	public function getConnection(): object
	{
		if (!$this->PDO) {
	        $dsn = "mysql:dbname=".$_ENV['DB_NAME'].";host=".$_ENV['DB_HOST'].";charset=".$_ENV['DB_ENCODING'];
			try
			{

				$this->PDO = new \PDO($dsn,$_ENV['DB_USER'],$_ENV['DB_PASSWORD'],
				array(
					\PDO::ATTR_PERSISTENT => $_ENV['attr_persistent'],
					\PDO::ATTR_PERSISTENT => ($_ENV['attr_errmode'] == true ? \PDO::ATTR_ERRMODE : \PDO::ERRMODE_SILENT)			
				));

			}
			catch(Exception $e)
			{
				die('Error connection : '.$e->getMessage());
			}
		}

		return $this->PDO;
	}

	/**
	* @param string $query SQL request sent to server
	* @param array $exec Values to be sent to the request 
	* @param object $class Class Entity used to treat the results as an object 
	*
    * @return object result of the query request
    */
	public function request(string $query,array $exec = NULL,Entity $class = NULL): \PDO
	{	
		$pdo = $this->getConnection();

		if ($exec === NULL) {
			$query = $pdo->query($query);

			if ($class) {
				$query->setFetchMode(\PDO::FETCH_CLASS,get_class($class));
			}

			if ($query->rowCount() > 1) {
				return $query->fetchAll();
			}

			return $query->fetch();
		}

		$query = $pdo->prepare($query);
		$query->execute($exec);

		if ($class) {
			$query->setFetchMode(\PDO::FETCH_CLASS,get_class($class));
		}

		if ($query->rowCount() > 1) {
			return $query->fetchAll();
		}

		return $query->fetch();	

	}

}

?>