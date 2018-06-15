<?php
declare(strict_types=1);

// form example with every type of field

require 'init.inc';
require 'validate.inc';

use It_All\FormFormer\Form;
use It_All\FormFormer\Fieldset;
use It_All\FormFormer\Fields\InputField;
use It_All\FormFormer\Fields\InputFields\CheckboxRadioInputField;
use It_All\FormFormer\Fields\SelectOption;
use It_All\FormFormer\Fields\SelectOptionGroup;
use It_All\FormFormer\Fields\DatalistField;
use It_All\FormFormer\Fields\TextareaField;
use It_All\FormFormer\Fields\SelectField;
use It_All\FormFormer\Fields\OutputField;
use It_All\FormFormer\Fields\MeterProgressField;

$fieldValidation = [
    'f1name' => [
        'required' => true
    ],
    'num1' => [
        'required' => true
    ],
    'sel1' => [
        'required' => true
    ],
    'radioGroup' => [
        'required' => true
    ]
];

// initialize necessary values (any that are sent to field constructors)
$fieldValues = [
    'f1name' => '',
    'num1' => '',
    'num2' => '',
    'f11name' => '',
    'f12name' => '',
    'sel1' => 'val2', // prepopulate
    'textList' => '',
    'radioGroup' => ''
];

// initialize necessary errors (any that are sent to field constructors)
$fieldErrors = [
    'f1name' => '',
    'num1' => '',
    'num2' => '',
    'f11name' => '',
    'f12name' => '',
    'sel1' => '',
    'textList' => '',
    'radioGroup' => null
];

// submission processing and validation
if (isset($_POST['sub'])) {

    foreach ($_POST as $k => $v) {
        $fieldValues[$k] = $v;
    }

    list($valid, $validationErrors) = validate($fieldValidation, $fieldValues);

    if ($valid) {
        die ('valid submission. time to process :)');
    }
    // if validate returns false, redisplay form with validation errors

    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }
}

// define fields and fieldsets

$f1 = new InputField('Text Field', ['value' => $fieldValues['f1name'], 'id' => 'f1id', 'name' => 'f1name', 'size' => 18, 'required' => 'required'], $fieldErrors['f1name']);

$textList = new InputField('City', ['value' => $fieldValues['textList'], 'id' => 'textList', 'name' => 'textList', 'list' => 'cityList'], $fieldErrors['textList']);

$cityList = new DatalistField(['New Haven', 'Hamden', 'Las Vegas', 'Kalamazoo'], ['id' => 'cityList'], '');

$num1 = new InputField('Number 1', ['type' => 'number', 'id' => 'num1', 'name' => 'num1', 'min' => 1, 'max' => 100, 'value' => $fieldValues['num1'], 'required' => 'required'], $fieldErrors['num1']);

$num2 = new InputField('Number 2', ['type' => 'number', 'id' => 'num2', 'name' => 'num2', 'min' => 1, 'max' => 100, 'value' => $fieldValues['num2'], 'required' => 'required'], $fieldErrors['num2']);

$output = new OutputField('', 'Number 1 + Number 2', ['name' => 'outputResult', 'for' => 'num1 num2']);

$f3 = new TextareaField('initial text', 'Enter Some Text', ['rows' => 4, 'cols' => 50]);

$opt0 = new SelectOption('-- select --', '', true, true);
$opt1 = new SelectOption('text1', 'val1');
$opt2 = new SelectOption('text2', 'val2');
$opt3 = new SelectOption('text3', 'val3');
$optgrp1 = new SelectOptionGroup([$opt1, $opt2, $opt3], 'optgroup1');

$opt11 = new SelectOption('text11', 'val11');
$opt22 = new SelectOption('text22', 'val22');
$opt33 = new SelectOption('text33', 'val33');
$optgrp2 = new SelectOptionGroup([$opt11, $opt22, $opt33], 'optgroup2');

$f4 = new SelectField([$opt0, $optgrp1, $optgrp2], $fieldValues['sel1'], 'select', ['name' => 'sel1', 'required' => 'required'], $fieldErrors['sel1']);

$f11 = new InputField('Favorite Flavor', ['id' => 'f11id', 'name' => 'f11name'], $fieldErrors['f11name']);

$f12 = new InputField('Number Field', ['type' => 'number']);

$fs11checkbox = new CheckboxRadioInputField('', ['type' => 'checkbox', 'name' => 'fslegcb', 'onchange' => 'allform.fs11.disabled = !allform.fs11.disabled']);

$fs11 = new Fieldset([$f11, $f12], ['name' => 'fs11', 'disabled' => 'disabled'], true, ' inner fieldset (check to enable fields)', $fs11checkbox);

$fs1 = new Fieldset([$f1, $num1, $fs11], [], true, 'outer fieldset');

$progress = new MeterProgressField('progress', '', 'Progress', ['max' => 100, 'value' => 54]);

$meter = new MeterProgressField('meter', 'test content', 'Meter', ['value' => .3]);

$button = new InputField('Undefined Button', ['type' => 'button', 'value' => 'click']);

$color = new InputField('Brown', ['type' => 'color', 'value' => '#2c1b04']);

$date = new InputField('Date', ['type' => 'date']);

$email = new InputField('Email', ['type' => 'email']);

$file = new InputField('', ['type' => 'file']);

$hidden = new InputField('', ['type' => 'hidden', 'name' => 'x', 'value' => 'y']);

$image = new InputField('', ['type' => 'image', 'src' => 'images/ralph-nader-button.jpg']);

$range = new InputField('', ['type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5]);

$pw = new InputField('', ['type' => 'password', 'placeholder' => 'enter password']);

$radioGroupAttributes = [
    'type' => 'radio',
    'name' => 'radioGroup',
    'class' => 'inlineField'
];
$radio1Attributes = array_merge($radioGroupAttributes, ['value' => 'a', 'id' => 'radio1']);
if ($fieldValues['radioGroup'] == 'a') {
    $radio1Attributes['checked'] = 'checked';
}
$radio2Attributes = array_merge($radioGroupAttributes, ['value' => 'b', 'id' => 'radio2']);
if ($fieldValues['radioGroup'] == 'b') {
    $radio2Attributes['checked'] = 'checked';
}
$radio3Attributes = array_merge($radioGroupAttributes, ['value' => 'c', 'id' => 'radio3']);
if ($fieldValues['radioGroup'] == 'c') {
    $radio3Attributes['checked'] = 'checked';
}
$radio1 = new CheckboxRadioInputField('a', $radio1Attributes);
$radio2 = new CheckboxRadioInputField('b', $radio2Attributes);
$radio3 = new CheckboxRadioInputField('c', $radio3Attributes);
$radioFs = new Fieldset([$radio1, $radio2, $radio3], [], true, 'Choose 1', null, $fieldErrors['radioGroup']);

// note can use either Class
$cb = new InputField('Check if you agree', ['type' => 'checkbox', 'class' => 'inlineField'], '', false);

$cb2 = new CheckboxRadioInputField('Uncheck if you disagree', ['type' => 'checkbox', 'checked' => 'checked', 'class' => 'inlineField']);

$reset = new InputField('', ['type' => 'reset']);

$search = new InputField('', ['type' => 'search', 'placeholder' => 'search']);

$tel = new InputField('', ['type' => 'tel', 'placeholder' => 'tel']);

$time = new InputField('', ['type' => 'time']);
$url = new InputField('', ['type' => 'url', 'placeholder' => 'url']);
$week = new InputField('', ['type' => 'week']);

$sub = new InputField('', ['type' => 'submit', 'name' => 'sub', 'value' => 'Go!']);

// top level fields and fieldsets (fields within fieldsets are not included)
$nodes = [$fs1, $textList, $cityList, $num2, $output, $f3, $f4, $progress, $meter, $button, $color, $date, $email, $file, $hidden, $image, $range, $pw, $radioFs, $cb, $cb2, $reset, $search, $tel, $time, $url, $week, $sub];

$form = new Form($nodes, ['name' => 'allform', 'method' => 'post', 'novalidate' => 'novalidate', 'oninput' => 'outputResult.value=parseInt(num1.value)+parseInt(num2.value)']);

$template = new Template($form);
$template->render();
