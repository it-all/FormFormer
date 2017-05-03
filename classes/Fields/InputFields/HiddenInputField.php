<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class HiddenInputField extends \It_All\FormFormer\Fields\InputField
{
    public function generate(bool $showLabel = false, bool $showReqdOpt = false, bool $showErrorMsg = false, bool $showDescriptor = false, bool $divWrap = false, bool $endWrapperDiv = false): string
    {
        return parent::generate(false, false, false, false, false);
    }
}
