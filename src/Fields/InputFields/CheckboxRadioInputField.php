<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class CheckboxRadioInputField extends \It_All\FormFormer\Fields\InputField
{
    // note still necessary to include type=radio attribute
    public function __construct(string $which = 'checkbox', string $label = '', array $attributes = [], string $errorMessage = '')
    {
        if ($which != 'checkbox' && $which != 'radio') {
            throw new \Exception('Invalid type $which');
        }
        parent::__construct($label, $attributes, $errorMessage, false); // false to put label after field
    }
}
