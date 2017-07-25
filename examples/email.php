<?php
declare(strict_types=1);

// email signup form with validation

require 'init.inc';

use It_All\FormFormer\Form;

$fieldValidation = [
    'email' => [
        'required' => true,
        'email' => true
    ]
];

$fieldValues = [
    'email' => '',
];

$fieldErrors = [
    'email' => '',
];

if (isset($_POST['sub'])) {

    foreach ($_POST as $k => $v) {
        $fieldValues[$k] = $v;
    }

    list($validated, $validationErrors) = validate($fieldValidation, $fieldValues);

    if ($validated) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, redisplay form with validation errors

    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

$email = new \It_All\FormFormer\Fields\InputField('Email', ['type' => 'email', 'id' => 'email', 'name' => 'email', 'value' => $fieldValues['email']], $fieldErrors['email']);

$sub = new \It_All\FormFormer\Fields\InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

$nodes = [$email, $sub];

$form = new Form($nodes, ['method' => 'post', 'novalidate' => 'novalidate']);

echo $twig->render('form.twig', array('form' => $form, 'focusFieldId' => $form->getFocusFieldId()));

function validate(array $rules, $values)
{
    $success = true;
    $errors = [];
    foreach ($rules as $fieldName => $fieldRules) {
        $value = (isset($values[$fieldName])) ? trim($values[$fieldName]): '';
        $errors[$fieldName] = ''; // initialize
        foreach ($fieldRules as $rule => $ruleContext) {
            switch ($rule) {
                case 'required':
                    if (strlen($value) == 0) {
                        $success = false;
                        $errors[$fieldName] = 'required';
                    }

                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $success = false;
                        $errors[$fieldName] = 'invalid';
                    }

            }
        }
    }
    return [$success, $errors];
}
