<?php
declare(strict_types=1);

require 'init.inc';

use It_All\FormFormer\Form;

$fieldValidation = [
    'f1name' => [
        'required' => true
    ],
    'f2name' => [
        'required' => true
    ],
    'sel1' => [
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

    $fieldValues= $_POST;

    list($validated, $validationErrors) = validate($fieldValidation, $fieldValues);

    if ($validated) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, redisplay form with validation errors

    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

// public function __construct(string $type, string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')

// note, attribute values must be strings
$f1 = new \It_All\FormFormer\Fields\InputField('Text Field', ['value' => $fieldValues['f1name'], 'id' => 'f1id', 'name' => 'f1name', 'size' => 18, 'required' => 'required'], $fieldErrors['f1name']);

$f2 = new \It_All\FormFormer\Fields\InputField('Number Field', ['type' => 'number', 'id' => 'f1id', 'name' => 'f2name', 'min' => 1, 'max' => 100, 'value' => $fieldValues['f2name'], 'required' => 'required'], $fieldErrors['f2name']);

//public function __construct(string $tag = 'input', string $label = '', string $value = '', array $attributes = [], string $errorMessage = '')
$f3 = new \It_All\FormFormer\Fields\TextareaField('Enter Some Text', 'initial idea', ['rows' => 4, 'cols' => 50]);

//option __construct(string $text, string $value, bool $isSelected = false, bool $isDisabled = false)
$opt0 = new \It_All\FormFormer\Fields\SelectOption('-- select --', '', true, true);

$opt1 = new \It_All\FormFormer\Fields\SelectOption('text1', 'val1');
$opt2 = new \It_All\FormFormer\Fields\SelectOption('text2', 'val2');
$opt3 = new \It_All\FormFormer\Fields\SelectOption('text3', 'val3');
$optgrp1 = new \It_All\FormFormer\Fields\SelectOptionGroup([$opt1, $opt2, $opt3], 'optgroup1');

$opt11 = new \It_All\FormFormer\Fields\SelectOption('text11', 'val11');
$opt22 = new \It_All\FormFormer\Fields\SelectOption('text22', 'val22');
$opt33 = new \It_All\FormFormer\Fields\SelectOption('text33', 'val33');
$optgrp2 = new \It_All\FormFormer\Fields\SelectOptionGroup([$opt11, $opt22, $opt33], 'optgroup2');

$f4 = new \It_All\FormFormer\Fields\SelectField([$opt0, $optgrp1, $optgrp2], 'select', ['name' => 'sel1', 'required' => 'required'], $fieldErrors['sel1']);

//$f11 = new \It_All\FormFormer\Fields\InputField('text', 'f11id', 'f11name', 'Text Field', $fieldValues['f11name'], true, '', null, null, $fieldErrors['f11name']);
//
//$f12 = new \It_All\FormFormer\Fields\InputField('number', '', 'f12name', 'Number Field');
//
//$fs11 = new \It_All\FormFormer\Fieldset([$f11, $f12], 'inner fieldset');

$fs1 = new \It_All\FormFormer\Fieldset([$f1, $f2], 'outer fieldset');

$sub = new \It_All\FormFormer\Fields\InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

$fields = [$f1, $f2, $f3, $f4, $sub];

$form = new Form($fields, 'post', false);

echo $twig->render('simple.twig', array('form' => $form, 'focusFieldId' => $form->getFocusFieldId()));

function validate(array $rules, $values)
{
    $success = true;
    $errors = [];
    foreach ($rules as $fieldName => $fieldRules) {
        $errors[$fieldName] = ''; // initialize
        foreach ($fieldRules as $rule => $ruleContext) {
            switch ($rule) {
                case 'required':
                    $value = (isset($values[$fieldName])) ? trim($values[$fieldName]): '';
                    if (strlen($value) == 0) {
                        $success = false;
                        $errors[$fieldName] = 'required';
                    }
            }
        }
    }
    return [$success, $errors];
}
