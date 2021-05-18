<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace AjdainiPHP\Core\Router;
use AjdainiPHP\Controller\AdminController;
use AjdainiPHP\Core\Controller\Controller;
use ReflectionClass;

class router 
{
	function __construct(Controller $controller)
	{

	}

	public static function Router(string $DefaultController = "AjdainiPHP\\Controller\\IndexController", string $DefaultMethod = "index")
	{	

		$ReflectionDefaultController = new ReflectionClass($DefaultController);

		if( ($ReflectionDefaultController->getParentClass() === FALSE) || ($ReflectionDefaultController->getParentClass()->getName() !== Controller::class))
		{
			throw new \Exception('Your Class must be an instance of : '.Controller::class);
		}


		$class = (isset($_GET['c']) ? "AjdainiPHP\\Controller\\".ucfirst($_GET['c']).'Controller' : $DefaultController);
		$target = (isset($_GET['t']) ? $_GET['t'] : $DefaultMethod);
		$getParams = (isset($_GET) ? $_GET : NULL);
		$postParams = (isset($_POST) ? $_POST : NULL);
		$params =
		[
			'get' => $getParams,
			'post' => $postParams
		];
		
		if (class_exists($class)) {
			
			$controller = new $class();

			if (method_exists($controller,$target)) {
				call_user_func(array($controller,$target),$params);
			}
			else
			{
				header('HTTP/1.0 404 Not Found');
    			exit;
			}
			
		}
		else
		{
			    header('HTTP/1.0 404 Not Found');
   				exit;
		}
	}
}

?>