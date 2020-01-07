<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\UserInterfaceHelper;

class SelectOption
{
    private $text;
    private $attributes;

    public function __construct(string $text, string $value, bool $isDisabled = false)
    {
        $this->text = $text;
        $this->setAttributes($value, $isDisabled);
    }

    private function setAttributes(string $value, bool $isDisabled)
    {
        $this->attributes['value'] = $value;

        if ($isDisabled) {
            $this->attributes['disabled'] = 'disabled';
        }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getValue(): string
    {
        return $this->attributes['value'];
    }

    private function addSelectedAttribute()
    {
        $this->attributes['selected'] = 'selected';
    }

    public function generate(?string $selectedValue = null): string
    {
        if ($selectedValue === $this->getValue()) {
            $this->addSelectedAttribute();
        }
        return UserInterfaceHelper::generateElement('option', $this->attributes, true, $this->text);
    }
}
