<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace AjdainiPHP\Core\Template;

class Template
{

	protected static $data = [];
	protected static $buffer = NULL;
	public static $page = NULL;
	public static $template_enable = false;

	/**
	 * @param string $buffer buffer name for the block
	 */
	public static function start(string $buffer)
	{
		self::$buffer = $buffer;
		ob_start();
	}

	/**
	 * End of the block 
	*/
	public static function end()
	{
		$content = ob_get_contents();
		ob_end_clean();
		self::$data[self::$buffer] = $content;
		self::$buffer = NULL;
	}

	/**
	 * @param string $page Template page to control the display 
	*/
	public static function load(string $page)
	{
		$page = self::$page = ROOT .'/Templates/' .$page;
		if(!file_exists($page))
		{
			throw new \Exception('Unable to load the template '. $page .', Please check that your file is correctly uploaded in the Templates folder.');
		}
		self::$template_enable = true;
	}

	
	public static function getData(): array
	{
		return self::$data;
	}

	public static function loadContent(string $page, array $params)
	{
		ob_start();
		$_TEMPLATE = Template::class;
		extract($params);
		require($page);

		$content = ob_get_contents();
		ob_end_clean();
	}

}

?>