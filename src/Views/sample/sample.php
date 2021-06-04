<?php

$_TEMPLATE::load('default.php');

$_TEMPLATE::start('title'); 

echo "AjdainiPHP Framework - Sample Page";

$_TEMPLATE::end();

$_TEMPLATE::start('body'); 

echo '<p> TITLE : '.$sample->title.'</p>';
echo '<p> SHORT DESCRIPTION : '.$sample->shortDescription.' ...</p>';
echo '<p> DATE ADDED : '.$sample->date_added.'</p>';

$_TEMPLATE::end();


?>