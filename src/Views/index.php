<?php

define('ROOT',dirname(__DIR__));
require_once(ROOT.'/../vendor/autoload.php');

use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use AjdainiPHP\Core\Router\router;
use AjdainiPHP\Core\Database\Database;
use AjdainiPHP\Controller\IndexController;

$dotenv = Dotenv::createImmutable(dirname(ROOT));
$dotenv->load();

router::Router(IndexController::class);

?>