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
    'f2name' => '',
    'f11name' => '',
    'f12name' => ''
];

$fieldErrors = [
    'f1name' => '',
    'f2name' => '',
    'f11name' => '',
    'f12name' => ''
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

// public function __construct(string $type, string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')

$f1 = new \It_All\FormFormer\Fields\InputFields\TextInputField('12', 'f1id', 'f1name', 'Text Field', $fieldValues['f1name'], true, 'enter text', null, null, $fieldErrors['f1name']);

// __construct(string $min = '', string $max = '', string $range = '', string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, string $placeholder = '', array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')

$f2 = new \It_All\FormFormer\Fields\InputFields\NumberInputField('0', '100', '5', 'f2id', 'f2name', 'Number Field', $fieldValues['f2name'], true, 'number', null);

$f11 = new \It_All\FormFormer\Fields\InputField('text', 'f11id', 'f11name', 'Text Field', $fieldValues['f11name'], true, '', null, null, $fieldErrors['f11name']);

$f12 = new \It_All\FormFormer\Fields\InputField('number', '', 'f12name', 'Number Field');

$fs11 = new \It_All\FormFormer\Fieldset([$f11, $f12], 'inner fieldset');

$fs1 = new \It_All\FormFormer\Fieldset([$f1, $f2, $fs11], 'outer fieldset');

$sub = new \It_All\FormFormer\Fields\InputField('submit', 'subid', 'sub', '', 'Go!');

$fields = [$fs1, $sub];

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
