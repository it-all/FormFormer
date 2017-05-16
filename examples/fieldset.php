<?php
// note this means every argument must be a string
declare(strict_types=1);

require('../vendor/autoload.php');

use It_All\FormFormer\Form;

arrayProtectRecursive($_POST);

// fieldset example
$form = new Form(['method' => 'post'], 'verbose');
$fs = $form->addFieldset()->legend('Registration');

$nameField = $fs->field()->name('name')->label('Name')->attr('required');
$fs->field('input', 'email')->name('email')->label('Email')->id('e');
$patternField = [
    'attributes' => [
        'pattern' => '[A-Za-z][0-9]{3}',
        'title' => 'A letter followed by 3 digits',
        'size' => 4,
        'maxlength' => 4
    ],
    'label' => 'Pattern'
];
$fs->addField('input', $patternField['attributes'], $patternField['label']);
//$fs->field()->attr('pattern', '[A-Za-z][0-9]{3}')->attr('title', 'A letter followed by 3 digits');
$fs->field('input', 'submit')->name('sub')->value('Go!');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (preg_match('/.[0-9]/', $_POST['name'])) {
       $form->setError($nameField, 'number in name');
    }
    $nameField->value($_POST['name']);
}

/**
 * protects array from xss by changing actual array values to escaped characters
 * @param array $arr
 */
function arrayProtectRecursive(array &$arr)
{
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            arrayProtectRecursive($arr[$k]);
        } else {
            $arr[$k] = htmlspecialchars($v, ENT_QUOTES | ENT_HTML401);
        }
    }
}

?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FormFormer</title>
    <meta name="description" content="FormFormer, an HTML form generation tool written in PHP by it-all.com">
    <meta name="author" content="it-all.com">

    <link rel="stylesheet" href="css/ffstyle.css?v=1.2">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
    <?php $form->render(); ?>
</body>
</html>