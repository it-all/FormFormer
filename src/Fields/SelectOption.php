<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

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
}
