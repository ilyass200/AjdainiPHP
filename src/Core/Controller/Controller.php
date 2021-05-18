<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AjdainiPHP\Core\Controller;
use AjdainiPHP\Core\Template\Template;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Intermediary between the model and the view 
 * 
 * All the logic of your code, data analysis, access rights management, the texts to be displayed on the view should be implemented in your controller 
 */
class Controller
{
	protected $viewPath = ROOT .'/Views/';

    /**
     *
     * The file that will be returned to process your variables and manage your page view
     *
     * @param string $page Name of your view file
     * @param array $params Variables to be treated in your view page
     *
     */
	public function render(string $page,array $params = []): mixed
	{

		if (substr($page, -4) === "twig") {
			$loader = new FilesystemLoader(ROOT.'/Views');
			$twig = new Environment($loader, [
				    'cache' => false
				]);

			echo $twig->render($page, $params);
			return true;
		}

		$_TEMPLATE = Template::class;
		$_TEMPLATE::loadContent($this->viewPath.$page,$params);

		if ($_TEMPLATE::$template_enable === false) {			

			require($this->viewPath.$page);
			return true;
		}

		extract(Template::getData());
		return require($_TEMPLATE::$page);

	}

	/**
     * @param string $path Link to your new View Folder
     */
	public function setViewPath(string $path)
	{
		$this->$viewPath = ROOT.'/'.$path;
	}

}

?>