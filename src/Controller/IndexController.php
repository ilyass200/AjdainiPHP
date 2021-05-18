<?php

namespace AjdainiPHP\Controller;
use AjdainiPHP\Core\Database\Database;
use AjdainiPHP\Core\Controller\Controller;

class IndexController extends Controller
{

	function __construct()
	{

	}

	public function index()
	{
		$this->render('main.php');
	}
}

?>