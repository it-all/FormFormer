<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class EmailInputField extends \It_All\FormFormer\Fields\InputField
{
    public function __construct(string $size = '', string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, string $placeholder = '', array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')
    {
        parent::__construct('email', $id, $name, $label, $value, $required, $placeholder, $cssClasses, $otherAttributes, $errorMessage);

        if (strlen($size) > 0) {
            $this->setAttribute('size', $size);
        }
    }
}
