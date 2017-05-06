<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

class RadioCheckboxInputField extends \It_All\FormFormer\Fields\InputField
{
    private $text = "";

    public function isChecked(): bool
    {
        return isset($this->attributes['checked']) && $this->attributes['checked'] == 'checked';
    }

    public function getValue()
    {
        if ($this->isChecked()) {
            return (isset($this->attributes['value'])) ? $this->attributes['value'] : '';
        }
        return null;
    }

    public function text(string $text)
    {
        $this->setText(trim($text));
        return $this;
    }

    private function setText(string $text)
    {
        $this->text = $text;
    }

    public function generate(): string
    {
        return parent::generate(true, true, true, true, true, "", false, $this->text);
    }
}
