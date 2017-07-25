<?php
declare(strict_types=1);

function validate(array $rules, $values)
{
    $success = true;
    $errors = [];
    foreach ($rules as $fieldName => $fieldRules) {
        $value = (isset($values[$fieldName])) ? trim($values[$fieldName]): '';
        $errors[$fieldName] = ''; // initialize
        foreach ($fieldRules as $rule => $ruleContext) {
            if (strlen($errors[$fieldName]) == 0) { // will stop processing field upon its first error
                switch ($rule) {
                    case 'required':
                        if (strlen($value) == 0) {
                            $success = false;
                            $errors[$fieldName] = 'required';
                        }
                        break;

                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $success = false;
                            $errors[$fieldName] = 'invalid';
                        }
                        break;

                }
            }
        }
    }
    return [$success, $errors];
}
