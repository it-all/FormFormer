<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class MeterField extends Field
{
    private $value;

    public function __construct(string $label = '', string $value = '', array $attributes = [], string $errorMessage = '')
    {
        $this->value = $value;
        parent::__construct('meter', $label, $attributes, $errorMessage);
    }

    public function getValue()
    {
        return $this->value;
    }
}
