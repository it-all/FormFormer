<?php
declare(strict_types=1);

require('../vendor/autoload.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
