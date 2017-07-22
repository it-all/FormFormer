<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class NumberInputField extends \It_All\FormFormer\Fields\InputField
{
    public function __construct(string $min = '', string $max = '', string $step = '', string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, string $placeholder = '', array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')
    {
        parent::__construct('number', $id, $name, $label, $value, $required, $placeholder, $cssClasses, $otherAttributes, $errorMessage);

        if (strlen($min) > 0) {
            $this->setAttribute('min', $min);
        }

        if (strlen($max) > 0) {
            $this->setAttribute('max', $max);
        }

        if (strlen($step) > 0) {
            $this->setAttribute('step', $step);
        }
    }
}
