<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\UserInterfaceHelper;

class OutputField extends Field
{
    private $value;

    public function __construct(string $value = '', string $label = '', array $attributes = [], string $errorMessage = '')
    {
        $this->value = $value;
        parent::__construct('output', $label, $attributes, $errorMessage);
    }

    public function getValue()
    {
        return $this->value;
    }
}
