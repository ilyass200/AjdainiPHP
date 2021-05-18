<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AjdainiPHP\Core\Entity;

/**
 * Retrieve the data from your query as an object 
 */
class Entity
{
	private $tableName = NULL;
	
	/**
	 * Call methods as properties (this method is called automatically if your property is not found)
	 */
	public function __get($key)
	{
		return $this->$key();
	}

	/**
	 * @param string $table the new name of your table 
	 */
	public function setTableName(string $table)
	{
		$this->tableName = $table;
	}
}

?>