<?php

namespace AjdainiPHP\Controller;
use AjdainiPHP\Table\SampleTable;
use AjdainiPHP\Core\Database\Database;
use AjdainiPHP\Core\Controller\Controller;

class IndexController extends Controller
{

	function __construct()
	{

	}

	public function sample($req)
	{
		$id = $req['get']['id'];
		$sampleTable = new SampleTable();
		$sample = $sampleTable->find($id);
		
		if(is_null($sample))
		{
			header('HTTP/1.0 404 Not Found');
			exit;
		}

		$this->render('sample/sample.php',compact('sample'));
	}

	public function samples()
	{
		$sampleTable = new SampleTable();
		$samples = $sampleTable->getAllSamples();	

		$this->render('sample/samples.php',compact('samples'));
	}

	public function index()
	{
		$this->render('main.php');
	}
}

?>