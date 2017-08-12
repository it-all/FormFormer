<?php
declare(strict_types=1);

// simple form with some default field values to test focus field

require 'init.inc';
require 'validate.inc';

use It_All\FormFormer\Form;

$name = new \It_All\FormFormer\Fields\InputField('Name', ['id' => 'name', 'name' => 'name', 'value' => 'Hu Man']);

$address = new \It_All\FormFormer\Fields\InputField('Address', ['id' => 'address', 'name' => 'address']);

$form = new Form([$name, $address], ['method' => 'post', 'novalidate' => 'novalidate']);

echo $twig->render('form.twig', ['form' => $form]);
