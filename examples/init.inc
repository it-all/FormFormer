<?php
declare(strict_types=1);

require('../vendor/autoload.php');

// minimal security to escape user input
foreach ($_POST as $key => $val) {
    $_POST[$key] = htmlspecialchars($val);
}

foreach ($_GET as $key => $val) {
    $_GET[$key] = htmlspecialchars($val);
}

require('Template.php');
