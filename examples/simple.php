<?php
declare(strict_types=1);

require 'init.inc';

use It_All\FormFormer\Form;

$fieldValidation = [
    'f1name' => [
        'required' => true
    ]
];

$fieldValues = [
    'f1name' => '',
    'f2name' => ''
];

$fieldErrors = [
    'f1name' => '',
    'f2name' => ''
];

if (isset($_POST['sub'])) {

    $fieldValues['f1name'] = $_POST['f1name'];
    $fieldValues['f2name'] = $_POST['f2name'];

    list($validated, $fieldErrors) = validate($fieldValidation, $fieldValues);

    if ($validated) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, form will redisplay with errors (set in validate)
}

// public function __construct(string $type, string $id = null, string $name = null, string $label = null, string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, bool $error = false, string $errorMessage = '')

$f1 = new \It_All\FormFormer\Fields\InputField('text', 'f1id', 'f1name', 'Text Field', $fieldValues['f1name'], true, null, null, $fieldErrors['f1name']);

$f2 = new \It_All\FormFormer\Fields\InputField('number', '', 'f2name', 'Number Field');

$sub = new \It_All\FormFormer\Fields\InputField('submit', 'subid', 'sub', '', 'Go!');

$fields = [$f1, $f2, $sub];

$form = new Form($fields, 'post', false);

echo $twig->render('simple.twig', array('form' => $form, 'focusFieldId' => $form->getFocusFieldId()));

function validate(array $rules, $values)
{
    $success = true;
    $fieldErrors = [];
    foreach ($rules as $fieldName => $fieldRules) {
        $fieldErrors[$fieldName] = ''; // initialize
        foreach ($fieldRules as $rule => $ruleContext) {
            switch ($rule) {
                case 'required':
                    if (strlen(trim($values[$fieldName])) == 0) {
                        $success = false;
                        $fieldErrors[$fieldName] = 'required';
                    }
            }
        }
    }

    return [$success, $fieldErrors];
}
