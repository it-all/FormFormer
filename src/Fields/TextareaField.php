<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\UserInterfaceHelper;

class TextareaField extends Field
{
    private $value;

    public function __construct(string $value = '', string $label = '', array $attributes = [], string $errorMessage = '')
    {
        $this->value = $value;
        parent::__construct('textarea', $label, $attributes, $errorMessage);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function generate(): string
    {
        $html = $this->generateDescriptors();
        $html .= UserInterfaceHelper::generateElement($this->tag, $this->attributes, true, $this->value);
        return $html;
    }
}
