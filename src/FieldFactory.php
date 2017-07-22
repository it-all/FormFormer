<?php
declare(strict_types=1);

namespace It_All\FormFormer\Factories;
use It_All\FormFormer\Fields\InputField;

/**
 * Class FieldFactory
 * @package It_All\FormFormer
 * validates the tag (html field element)
 * validates the input type
 */
class FieldFactory
{

    public static function create(string $tag = 'input', string $inputType = null, string $id = null, string $name = null, string $label = null, array $validation = [], bool $persist = true, bool $error = false, string $errorMessage = '')
    {
        if (strlen($tag) == 0) {
            $tag = 'input';
        }
        switch ($tag) {
            case 'input':

                //https://www.w3.org/TR/html5/forms.html#states-of-the-type-attribute
                $validInputTypes = array('hidden', 'text', 'search', 'tel', 'url', 'email', 'password', 'date', 'time', 'number', 'range', 'color', 'checkbox', 'radio', 'file', 'submit', 'image', 'reset', 'button');
                if (!in_array($inputType, $validInputTypes)) {
                    throw new \Exception('Invalid input type ' . $inputType);
                }

                $namespaceClassname = 'InputFields\\' . ucwords($inputType) . 'InputField';

                $field = new InputField($inputType, $id, $name, $label, $validation, $persist, $error, $errorMessage);

                break;

            case 'button':
            case 'meter':
            case 'output':
            case 'progress':
            case 'select':
            case 'textarea':
                $namespaceClassname = ucwords($tag) . "Field";
                break;

            default:
                throw new \Exception('Invalid field tag name ' . $tag);
        }

//        $namespaceClass = "It_All\\FormFormer\\Fields\\" . $namespaceClassname;
//        if (class_exists($namespaceClass)) {
//            $field = new $namespaceClass($id, $name, $label, $validation, $persist, $error,$errorMessage);
//        } else {
//            throw new \Exception('Class not found ' . $namespaceClass);
//        }

        return $field;
    }
}
