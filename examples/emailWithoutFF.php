<?php
declare(strict_types=1);

// email signup form with validation

require 'init.inc';
require 'validate.inc';

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
$generalFormError = false;

// submission processing and validation
if (isset($_POST['sub'])) {

    $fieldValues['email'] = trim($_POST['email']);

    list($validated, $validationErrors) = validate($fieldValidation, $fieldValues);

    if ($validated) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, redisplay form with validation errors
    $generalFormError = true;
    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

echo $twig->render('emailFormWithoutFF.twig', ['generalFormError' => $generalFormError, 'emailFieldValue' => $fieldValues['email'], 'emailFieldError' => $fieldErrors['email']]);
