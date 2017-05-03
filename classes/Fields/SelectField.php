<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class SelectField extends Field
{
    protected $tag = 'select';
    private $options;
    private $selectedOptionValue = false;

    private function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function options(array $options)
    {
        $this->setOptions($options);
        return $this;
    }

    public function sel(string $selectedValue)
    {
        $this->selectedOptionValue = $selectedValue;
        return $this;
    }

    public function setValue($value)
    {
        $this->selectedOptionValue = $value;
    }

    public function getValue()
    {
        return $this->selectedOptionValue;
    }

    private function isOptionSelected(string $optionValue): bool
    {
        if ($this->selectedOptionValue !== false && $this->selectedOptionValue == $optionValue) {
            return true;
        }
        return false;
    }

    private function getSelectedOptionAttribute(string $optionValue): string
    {
        if ($this->isOptionSelected($optionValue)) {
            return " selected";
        }
        return "";
    }

    private function getOption(string $optionText, string $optionValue): string
    {
        $selected = $this->getSelectedOptionAttribute($optionValue);
        return "<option value='$optionValue'$selected>$optionText</option>";
    }

    private function getOptionsHTML()
    {
        $html = "";
        if (array_key_exists("optgroups", $this->options)) {
            foreach ($this->options as $optgroups) {
                foreach ($optgroups as $optgroupName => $optgroupOptions) {
                    $html .= "<optgroup label='$optgroupName'>";
                    foreach ($optgroupOptions as $val => $opt) {
                        $html .= $this->getOption($opt, $val);
                    }
                    $html .= "</optgroup>";
                }
            }
        } else {
            foreach ($this->options as $option_value => $option_text) {
                $html .= $this->getOption((string) $option_text, (string) $option_value);
            }
        }
        return $html;
    }

    public function generate(): string
    {
        return parent::generate(true, true, true, true, true, $this->getOptionsHTML());
    }
}
