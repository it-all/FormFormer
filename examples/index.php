<?php
// note this means every argument must be a string
declare(strict_types=1);

require('../vendor/autoload.php');

use It_All\FormFormer\Form;

$form1Attributes = [
    'oninput' => 'out.value = parseInt(a.value) + parseInt(b.value)',
    'method' => 'post'
];
$form1 = new Form($form1Attributes);

// INPUT FIELDS

//hidden
$form1->field('input', 'hidden')->name('theNumber')->value('6');

// defaults to text input
$form1->field();

// special case leave input type blank for <input> field, not sure why you'd want to, probably a js thing
$form1->field('input', '');

//text
$form1->field()->name('customer')->label('Name')->attr('required');

//$form1->setFfgError($form1->findFieldByName('customer'), 'test error msg');

// email
$form1->field('input', 'email')->name('email')->label('Email')->id('e')->attr('required')->value('controlio@it-all.com');

// or set calling addField
$e2 = [
    'tag' => 'input',
    'attributes' => [
        'type' => 'email',
        'name'=>'email2'
    ],
    'label' => 'Additional Email'
];
$form1->addField($e2['tag'], $e2['attributes'], $e2['label']);

// search!
$form1->field('input', 'search')->attr('placeholder', 'Search');

// tel
$form1->field('input', 'tel')->label('Tel')->id('tele');

// url
$form1->field('input', 'url')->label('URL');

// password
$form1->field('input', 'password')->label('Password')->id('p1');

// date
$form1->field('input', 'date')->label('Date');

// time
$form1->field('input', 'time')->label('Time');

// number
$form1->field('input', 'number')->attr('min', '2')->attr('max', '10')->attr('step', '2')->value('2')->label('Number');

// range
$form1->field('input', 'range')->attr('min', '1')->attr('max', '10')->attr('step', '1')->value('5')->label('Range');

// color
$form1->field('input', 'color')->label('Color');

// checkbox
$form1->field('input', 'checkbox')->label('Checkbox, click me to check/toggle the box')->id('cb1');

// checkbox on
$form1->field('input', 'checkbox')->label('Checkbox, click me to uncheck/toggle the box')->id('cb2')->attr('checked');

// radio
$form1->field('input', 'radio')->label('Radio, click me to check and stay checked')->id('rb1');

// checkbox on
$form1->field('input', 'radio')->label('Radio, already checked and will stay that way')->id('rb2')->attr('checked')->text('test text');

$form1->addHtml('Why? <a href="https://ux.stackexchange.com/questions/13511/why-is-it-impossible-to-deselect-html-radio-inputs">&apos;Check&apos; this out.</a>');

// file - oops won't work without specifying form tag attribute enctype = multipart/form-data
// supposedly it will work with the get method, though I don't recommend it:
// http://stackoverflow.com/questions/15201976/file-uploading-using-get-method
$form1->field('input', 'file');

// image
// The image is given by the src attribute. The src attribute must be present, and must contain a valid non-empty URL potentially surrounded by spaces referencing a non-interactive, optionally animated, image resource that is neither paged nor scripted.
// https://www.w3.org/TR/html5/forms.html#image-button-state-(type=image)
$form1->field('input', 'image')->label('Image')->attr('src', 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png');

// reset
$form1->field('input', 'reset')->label('Reset - enter data, click button, data is gone');

// button
$form1->field('input', 'button')->label('Button with no action')->value('Click');

$form1->field('input', 'submit')->value('An Input Submit Field');

// SELECT FIELDS
$form1->field('select', '')->options(['val1' => 'opt1', 'val2' => 'opt2', 'val3' => 'opt3'])->sel('val2')->label('Select');

$options = [
    'optgroups' => [
            '' => ['' => 'select animal'],
        'dogs' => ['pb' => 'pit bull', 'db' => 'doberman', 'tr' => 'terrier'],
        'cats' => ['y' => 'yellow', 'b' => 'black']
    ]
];
$form1->field('select', '')->options($options)->label('Select');

// TEXTAREA
$form1->field('textarea', '')->value('in the box!')->id('txta');

// BUTTON FIELDS (slightly different than INPUT FIELDS with type='button')

// default (no type attribute) is a submit button
$form1->field('button', '')->content('Submit the form with a button field');

// or
$form1->field('button', 'submit')->content('Another submit button');

// reset
$form1->field('button', 'reset')->content('A reset button');

// button button - no predefined action
$form1->field('button', 'button')->content('Control me through js')->id('btn1');

// KEYGEN FIELD - DEPRECATED
// https://developer.mozilla.org/en-US/docs/Web/HTML/Element/keygen

// METER FIELD
// chrome doesn't seem to do anything w/ low/high/optimum
$form1->field('meter', '')->label('Meter')->id('met1')->min(1)->max(100)->value(40)->low(20)->high(80)->optimum(50);

// OUTPUT FIELD
$form1->field('input', 'number')->name('a')->id('a');
$form1->field('input', 'number')->name('b')->id('b');
$form1->field('output', '')->name('out')->label('Output')->forattr('a b');

////////////////////////////
// GROUP FIELDS

// radio - only 1 can be checked, though this won't throw an error, only the last will be checked
// no need for [] after the name as only 1 value can be checked and therefore received upon submission
$form1->addFieldGroup('radio', 'rg1','Radio Group', '', true)->choices(['one' => 1, 'two' => [2, true], 'three' => [3, true]]);

// checkbox
$form1->addFieldGroup('checkbox', 'cg1[]','Checkbox Group')->choices(['one' => [1, true], 'two' => [2, true], 'three' => 3]);

// files
$form1->addFieldGroup('file', 'fg1[]','File Group')->num(4);

// END GROUP FIELDS
////////////////////////////
//
$form1->field('input', 'submit')->name('sub');

// fieldset example
$form2 = new Form();
$f2fs = $form2->addFieldset()->legend('Registration');

$f2fs->field()->name('name')->label('Name');
$f2fs->field('input', 'email')->name('email')->label('Email')->id('e');
$patternField = [
    'attributes' => [
        'pattern' => '[A-Za-z][0-9]{3}',
        'title' => 'A letter followed by 3 digits',
        'size' => 4,
        'maxlength' => 4
    ],
    'label' => 'Pattern'
];
$f2fs->addField('input', $patternField['attributes'], $patternField['label']);
$f2fs->field('input', 'submit')->name('sub')->value('Go!');


if (isset($_POST['sub']))
{
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FormFormer</title>
    <meta name="description" content="FormFormer, an HTML form generation tool written in PHP by it-all.com">
    <meta name="author" content="it-all.com">

    <link rel="stylesheet" href="css/ffstyle.css?v=1.11">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
    <?php $form1->render(); ?>
    <br>
    <?php $form2->render(); ?>
</body>
</html>