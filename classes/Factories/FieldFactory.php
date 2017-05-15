<?php
declare(strict_types=1);

namespace It_All\FormFormer\Factories;

/**
 * Class FieldFactory
 * @package It_All\FormFormer
 * validates the tag (html field element)
 * validates the input type
 */
class FieldFactory
{

    public static function create(string $tag = 'input', array $attributes = [], string $label = '', string $descriptor = '', array $customFieldSettings = [])
    {
        if (strlen($tag) == 0) {
            $tag = 'input';
        }
        switch ($tag) {
            case 'input':
                if (!isset($attributes['type'])) {

                    // allow <input> tag without type attribute by not defaulting type to text
                    $namespaceClassname = 'InputField';

                } else {

                    $attributes['type'] = strtolower(trim($attributes['type']));

                    //https://www.w3.org/TR/html5/forms.html#states-of-the-type-attribute
                    $validInputTypes = array('hidden', 'text', 'search', 'tel', 'url', 'email', 'password', 'date', 'time', 'number', 'range', 'color', 'checkbox', 'radio', 'file', 'submit', 'image', 'reset', 'button');
                    if (!in_array($attributes['type'], $validInputTypes)) {
                        throw new \Exception('Invalid input type ' . $attributes['type']);
                    }

                    $namespaceClassname = 'InputFields\\' . ucwords($attributes['type']) . 'InputField';

                }
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

        $namespaceClass = "It_All\\FormFormer\\Fields\\" . $namespaceClassname;
        if (class_exists($namespaceClass)) {
            $field = new $namespaceClass($attributes, $label, $descriptor, $customFieldSettings);
        } else {
            throw new \Exception('Class not found ' . $namespaceClass);
        }

        return $field;
    }
}
