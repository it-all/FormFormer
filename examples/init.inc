<?php
declare(strict_types=1);

require('../vendor/autoload.php');

$templateLoader = new Twig_Loader_Filesystem(['templates', '../src/twigMacros']);
$twig = new Twig_Environment($templateLoader);
