<?php
declare(strict_types=1);

// simple form with some default field values to test focus field

require 'init.inc';
require 'validate.inc';

use It_All\FormFormer\Form;

$name = new \It_All\FormFormer\Fields\InputField('Name', ['id' => 'name', 'name' => 'name', 'value' => 'Hu Man']);

$address = new \It_All\FormFormer\Fields\TextareaField('1 way', 'Address');

$oa = new \It_All\FormFormer\Fields\SelectOption('-- select --', '');
$o1 = new \It_All\FormFormer\Fields\SelectOption('s1', 's1');
$o2 = new \It_All\FormFormer\Fields\SelectOption('s2', 's2');
$state = new \It_All\FormFormer\Fields\SelectField([$oa, $o1, $o2], 's1', 'State', ['id' => 'state']);

$city = new \It_All\FormFormer\Fields\InputField('City', ['id' => 'city', 'name' => 'city']);

$form = new Form([$name, $address, $state, $city], ['method' => 'post', 'novalidate' => 'novalidate']);

echo $twig->render('form.twig', ['form' => $form]);
