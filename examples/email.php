<?php
declare(strict_types=1);

// email signup form with validation

require 'init.inc';
require 'validate.inc';

use It_All\FormFormer\Form;

$fieldValidation = [
    'email' => [
        'required' => true,
        'email' => true
    ]
];

// initialize
$fieldValues = [
    'email' => '',
];

// initialize
$fieldErrors = [
    'email' => '',
];

// submission processing and validation
if (isset($_POST['sub'])) {

    $fieldValues['email'] = trim($_POST['email']);

    list($valid, $validationErrors) = validate($fieldValidation, $fieldValues);

    if ($valid) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, redisplay form with validation errors

    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

$email = new \It_All\FormFormer\Fields\InputField('Email', ['type' => 'email', 'id' => 'email', 'name' => 'email', 'value' => $fieldValues['email'], 'required' => 'required'], $fieldErrors['email']);

$sub = new \It_All\FormFormer\Fields\InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

$nodes = [$email, $sub];

$form = new Form($nodes, ['method' => 'post', 'novalidate' => 'novalidate']);

echo $twig->render('form.twig', array('form' => $form, 'focusFieldId' => $form->getFocusFieldId()));
