<?php
declare(strict_types=1);

// example using FieldBuilder API

require 'init.inc';

use It_All\FormFormer\Form;
use It_All\FormFormer\FieldBuilder;
use It_All\FormFormer\Fields\SelectOption;

$fb = new FieldBuilder();

$fields = [];

$fields[] = $fb->tag('input')->label('Name')->build();
$fields[] = $fb->build(); // blank input field
$fields[] = $fb->label('field 2')->err('Test Error')->build(); // causes Submission Error top error message too
$fields[] = $fb->attr(['type' => 'number'])->build();
$fields[] = $fb->attr(['type' => 'checkbox', 'class' => 'inlineField'])->label('world is oval')->build();

$opt0 = new SelectOption('-- select --', '');
$opt1 = new SelectOption('text1', 'val1');
$opt2 = new SelectOption('text2', 'val2');
$opt3 = new SelectOption('text3', 'val3');
$fields[] = $fb->tag('select')->selOpt([$opt0, $opt1, $opt2, $opt3])->build();

$fields[] = $fb->tag('textarea')->textVal('add more text please')->build();
$fields[] = $fb->attr(['type' => 'submit', 'value' => 'Nothing happens'])->build();

$form = new Form($fields);
$template = new Template($form);
$template->render();
