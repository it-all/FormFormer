<?php
declare(strict_types=1);

require 'init.inc';

$template = new Template();

$body = <<< EOL
<h1>FormFormer</h1>
<h2>by <a href="https://github.com/it-all" target="_blank">it-all.com</a></h2>
<ul>
    <li><a href="valitron.php" target="_blank">validation using <a href="https://github.com/vlucas/valitron" taget="_blank">Valitron</a></li>
    <li><a href="all.php" target="_blank">all field types, nested fieldsets,and some validation</a></li>
    <li><a href="builder.php" target="_blank">fields created using FieldBuilder API</a></li>
    <li><a href="email.php" target="_blank">simple email sign up form with validation</a></li>
    <li><a href="simpleDefaults.php" target="_blank">simple form to test focus field</a></li>
</ul>
EOL;

$template->setBodyContent($body);
$template->render();
