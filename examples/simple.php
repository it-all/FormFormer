<?php
declare(strict_types=1);

require 'init.inc';

use It_All\FormFormer\Form;

$fieldValidation = [
    'f1name' => [
        'required' => true
    ],
    'num1' => [
        'required' => true
    ],
    'sel1' => [
        'required' => true
    ]
];

$fieldValues = [
    'f1name' => '',
    'num1' => '',
    'num2' => '',
    'f11name' => '',
    'f12name' => '',
    'sel1' => ''
];

$fieldErrors = [
    'f1name' => '',
    'num1' => '',
    'num2' => '',
    'f11name' => '',
    'f12name' => '',
    'sel1' => ''
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

// public function __construct(string $type, string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')

// note, attribute values must be strings
$f1 = new \It_All\FormFormer\Fields\InputField('Text Field', ['value' => $fieldValues['f1name'], 'id' => 'f1id', 'name' => 'f1name', 'size' => 18, 'required' => 'required'], $fieldErrors['f1name']);

$num1 = new \It_All\FormFormer\Fields\InputField('Number 1', ['type' => 'number', 'id' => 'num1', 'name' => 'num1', 'min' => 1, 'max' => 100, 'value' => $fieldValues['num1'], 'required' => 'required'], $fieldErrors['num1']);

$num2 = new \It_All\FormFormer\Fields\InputField('Number 2', ['type' => 'number', 'id' => 'num2', 'name' => 'num2', 'min' => 1, 'max' => 100, 'value' => $fieldValues['num2'], 'required' => 'required'], $fieldErrors['num2']);

$output = new \It_All\FormFormer\Field('output', 'Number 1 + Number 2', ['name' => 'outputResult', 'for' => 'num1 num2']);

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

$f4 = new \It_All\FormFormer\Fields\SelectField([$opt0, $optgrp1, $optgrp2], 'select', $fieldValues['sel1'], ['name' => 'sel1', 'required' => 'required'], $fieldErrors['sel1']);

//$f11 = new \It_All\FormFormer\Fields\InputField('text', 'f11id', 'f11name', 'Text Field', $fieldValues['f11name'], true, '', null, null, $fieldErrors['f11name']);
//
//$f12 = new \It_All\FormFormer\Fields\InputField('number', '', 'f12name', 'Number Field');
//
//$fs11 = new \It_All\FormFormer\Fieldset([$f11, $f12], 'inner fieldset');

$fs1 = new \It_All\FormFormer\Fieldset([$f1, $num1], 'outer fieldset');

$f5 = new \It_All\FormFormer\Field('progress', 'Progress', ['max' => 100, 'value' => 54]);
$f6 = new \It_All\FormFormer\Field('meter', 'Meter', ['value' => .3]);

$button = new \It_All\FormFormer\Fields\InputField('Undefined Button', ['type' => 'button', 'value' => 'click']);

$color = new \It_All\FormFormer\Fields\InputField('Brown', ['type' => 'color', 'value' => '#2c1b04']);

$date = new \It_All\FormFormer\Fields\InputField('Date', ['type' => 'date']);

$email = new \It_All\FormFormer\Fields\InputField('Email', ['type' => 'email']);

$file = new \It_All\FormFormer\Fields\InputField('', ['type' => 'file']);

$hidden = new \It_All\FormFormer\Fields\InputField('', ['type' => 'hidden', 'name' => 'x', 'value' => 'y']);

$image = new \It_All\FormFormer\Fields\InputField('', ['type' => 'image', 'src' => 'images/ralph-nader-button.jpg']);

$range = new \It_All\FormFormer\Fields\InputField('', ['type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5]);

$pw = new \It_All\FormFormer\Fields\InputField('', ['type' => 'password', 'placeholder' => 'enter password']);

$radio1 = new \It_All\FormFormer\Fields\InputFields\RadioInputField('a', ['type' => 'radio', 'name' => 'radioGroup', 'value' => 'a', 'id' => 'radio1']);
$radio2 = new \It_All\FormFormer\Fields\InputFields\RadioInputField('b', ['type' => 'radio', 'name' => 'radioGroup', 'value' => 'b', 'id' => 'radio2']);
$radio3 = new \It_All\FormFormer\Fields\InputFields\RadioInputField('c', ['type' => 'radio', 'name' => 'radioGroup', 'value' => 'c', 'id' => 'radio3']);
$radioFs = new \It_All\FormFormer\Fieldset([$radio1, $radio2, $radio3], 'Choose 1');

$cb = new \It_All\FormFormer\Fields\InputFields\CheckboxInputField('Check if you agree', ['type' => 'checkbox']);

$cb2 = new \It_All\FormFormer\Fields\InputFields\CheckboxInputField('Uncheck if you disagree', ['type' => 'checkbox', 'checked' => 'checked']);

$reset = new \It_All\FormFormer\Fields\InputField('', ['type' => 'reset']);

$search = new \It_All\FormFormer\Fields\InputField('', ['type' => 'search', 'placeholder' => 'search']);

$tel = new \It_All\FormFormer\Fields\InputField('', ['type' => 'tel', 'placeholder' => 'tel']);

$time = new \It_All\FormFormer\Fields\InputField('', ['type' => 'time']);
$url = new \It_All\FormFormer\Fields\InputField('', ['type' => 'url', 'placeholder' => 'url']);
$week = new \It_All\FormFormer\Fields\InputField('', ['type' => 'week']);

$sub = new \It_All\FormFormer\Fields\InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

$nodes = [$f1, $num1, $num2, $output, $f3, $f4, $f5, $f6, $button, $color, $date, $email, $file, $hidden, $image, $range, $pw, $radioFs, $cb, $cb2, $reset, $search, $tel, $time, $url, $week, $sub];

$form = new Form($nodes, ['method' => 'post', 'novalidate' => 'novalidate', 'oninput' => 'outputResult.value=parseInt(num1.value)+parseInt(num2.value)']);

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
