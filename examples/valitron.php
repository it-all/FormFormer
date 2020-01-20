<?php
declare(strict_types=1);

// validates (minimal) form submission using Valitron

require('../vendor/autoload.php');
require('Template.php');

use It_All\FormFormer\Validator;
use It_All\FormFormer\Form;
use It_All\FormFormer\Fields\InputField;

// create constant form method and use it in form attributes and submission test clause
define('FORM_METHOD', 'POST');

// create constant array of field names and use them to initialize field values, initialize field errors, and to check for extraneous user input
// technically this does not include the submit field
define('FIELD_NAMES', ['name', 'email']);

// these fields (ie checkbox) are not validated to be part of input because they may not be present (ie if unchecked)
define('BOOLEAN_FIELD_NAMES', []); 

// create constant submit field name and use it in submit field attributes and submission test clause
// pretty sure i remember an old browser bug if you simply used 'submit'. probly ie.
define('SUBMIT_FIELD_NAME', 'submitField');

list($fieldValues, $fieldErrors) = initialize();

// submission processing and validation
$methodInput = FORM_METHOD === 'POST' ? $_POST : $_GET;
if (isset($methodInput[SUBMIT_FIELD_NAME])) {

    $fieldValues = getSubmittedValues();
    $validator = new Validator($fieldValues);
    setValidation($validator);

    if ($validator->isValid()) {
        echo ('Valid submission.');
        list($fieldValues, $fieldErrors) = initialize();
    } else {
        $fieldErrors = $validator->getErrors();
    }
}

$form = createForm($fieldValues, $fieldErrors);
$template = new Template($form);

// OUTPUT
$template->render();

// FUNCTIONS

function setValidation(Validator $validator) 
{
    $validator->rule('required', ['name', 'email']);
    $validator->rule('alpha', 'name');
    $validator->rule('email', 'email');
}

function setErrors(array $validationErrors): array
{
    $fieldErrors = [];
    foreach ($validationErrors as $fieldName => $error) {
        $fieldErrors[$fieldName] = $error;
    }

    return $fieldErrors;
}

// throw Exception for extraneous input
// throw Exception if not all field values are defined (except the submit field)
function getSubmittedValues(bool $checkBools = false): array
{
    $fieldValues = [];
    $methodInput = FORM_METHOD === 'POST' ? $_POST : $_GET;
    foreach ($methodInput as $k => $v) {
        if ($k != SUBMIT_FIELD_NAME && !in_array($k, FIELD_NAMES)) {
            throw new \Exception("Extraneous Input Key: $k");
        }
        $fieldValues[$k] = $v;
    }
    if (!allFieldValuesSet($fieldValues, $checkBools)) {
        throw new \Exception("Missing Field Values");
    }

    return $fieldValues;
}

function allFieldValuesSet(array $fieldValues, bool $checkBools = false): bool 
{
    foreach (FIELD_NAMES as $fieldName) {
        if (!in_array($fieldName, BOOLEAN_FIELD_NAMES) || $checkBools) {
            if (!array_key_exists($fieldName, $fieldValues)) {
                return false;
            }
        }
    }

    return true;
}

function createForm(array $fieldValues, array $fieldErrors): Form 
{
    // define fields 
    $nameField = new InputField('Name', ['value' => $fieldValues['name'], 'id' => 'name', 'name' => 'name', 'size' => 25, 'required' => 'required'], $fieldErrors['name']);
    $emailField = new InputField('Email', ['value' => $fieldValues['email'], 'id' => 'email', 'name' => 'email', 'type' => 'email', 'size' => 25, 'required' => 'required'], $fieldErrors['email']);
    $submitField = new InputField('', ['type' => 'submit', 'name' => SUBMIT_FIELD_NAME, 'value' => 'Go!']);
    $nodes = [$nameField, $emailField, $submitField];

    // action defaults to submitting to current page
    return new Form($nodes, ['name' => 'itallform', 'method' => strtolower(FORM_METHOD), 'novalidate' => 'novalidate']);
}

function initializeFieldValues(): array
{
    $fieldValues = [];
    foreach (FIELD_NAMES as $fieldName) {
        $fieldValues[$fieldName] = '';
    }

    return $fieldValues;
}

function initializeFieldErrors(): array
{
    $fieldErrors = [];
    foreach (FIELD_NAMES as $fieldName) {
        $fieldErrors[$fieldName] = '';
    }

    return $fieldErrors;
}

function initialize(): array 
{
    $fieldValues = initializeFieldValues();
    $fieldErrors = initializeFieldErrors();
    return [$fieldValues, $fieldErrors];
}
