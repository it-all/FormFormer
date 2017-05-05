<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class SubmitInputField extends \It_All\FormFormer\Fields\InputField
{
    protected $type = 'submit';

    function __construct(array $attributes = [], string $label = '', string $descriptor = '')
    {
        if (!isset($attributes['value'])) {
            $attributes['value'] = 'Submit';
        }
        parent::__construct($attributes, $label, $descriptor);
    }

    public function generate(bool $showLabel = false, bool $showReqdOpt = false, bool $showErrorMsg = false, bool $showDescriptor = false, bool $divWrap = true, bool $endWrapperDiv = true): string
    {
        return parent::generate($showLabel, false, false, $showDescriptor, $divWrap);
    }
}
