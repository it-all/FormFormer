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

// initialize
$formErrorMessage = '';

// submission processing and validation
if (isset($_POST['sub'])) {

    $fieldValues['email'] = trim($_POST['email']);

    list($valid, $validationErrors) = validate($fieldValidation, $fieldValues);

    // let's say we need to also verify the email doesn't already exist in our system
    if (emailExists($fieldValues['email'])) {
        $formErrorMessage = 'Email Already Exists';
        $valid = false;
    }

    if ($valid) {
        die ('valid submission. time to process :)');
    }

    // if validate returns false, redisplay form with validation errors
    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

// set to return true to produce general form error or false to hide
function emailExists(string $email)
{
    return false;
}

$email = new \It_All\FormFormer\Fields\InputField('Email', ['type' => 'email', 'id' => 'email', 'name' => 'email', 'value' => $fieldValues['email'], 'required' => 'required'], $fieldErrors['email']);

$sub = new \It_All\FormFormer\Fields\InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

$nodes = [$email, $sub];

$form = new Form($nodes, ['method' => 'post', 'novalidate' => 'novalidate'], $formErrorMessage);
$template = new Template($form);
$template->render();
