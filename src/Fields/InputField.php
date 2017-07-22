<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class InputField extends Field
{
    protected $type;

    /** not sure if there's a viable use case for an input tag with no type defined (defaults to text). i'm assuming no and will modify if proven wrong */

    public function __construct(string $type, string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')
    {
        //https://www.w3.org/TR/html5/forms.html#states-of-the-type-attribute
        $validInputTypes = array('hidden', 'text', 'search', 'tel', 'url', 'email', 'password', 'date', 'time', 'number', 'range', 'color', 'checkbox', 'radio', 'file', 'submit', 'image', 'reset', 'button');

        if (!in_array($type, $validInputTypes)) {
            throw new \Exception('Invalid input type ' . $type);
        }

        $this->type = $type;

        parent::__construct('input', $id, $name, $label, $value, $required, $cssClasses, $otherAttributes, $errorMessage);

        $this->setAttribute('type', $type);

        if ($value !== null && strlen($value) > 0) {
            $this->setAttribute('value', $value);
        }
    }

    public function getType(): string
    {
        return $this->type;
    }
}
