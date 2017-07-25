<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class RadioInputField extends \It_All\FormFormer\Fields\InputField
{
    public function __construct(string $label = '', array $attributes = [], string $errorMessage = '')
    {
        parent::__construct($label, $attributes, $errorMessage, false); // false to put label after field
    }
}
