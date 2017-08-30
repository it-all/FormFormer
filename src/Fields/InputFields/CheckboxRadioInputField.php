<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

/**
 * Class CheckboxRadioInputField
 * @package It_All\FormFormer\Fields\InputFields
 * the only difference with InputField is $isLabelBefore defaults false
 */
class CheckboxRadioInputField extends \It_All\FormFormer\Fields\InputField
{
    // note still necessary to include type=radio or type=checkbox attribute
    public function __construct(string $label = '', array $attributes = [], string $errorMessage = '', $isLabelBefore = false)
    {
        parent::__construct($label, $attributes, $errorMessage, $isLabelBefore); // false to put label after field
    }
}
