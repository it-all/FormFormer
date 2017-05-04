<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class SelectField extends Field
{
    protected $tag = 'select';

    /** @var array [val1 => text1, ...] */
    private $options = [];

    private $placeholder;

    private $selectedOptionValue = false;

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param string $selectedValue
     * @return $this
     * note, this overrides any placeholder
     */
    public function sel(string $selectedValue)
    {
        $this->selectedOptionValue = $selectedValue;
        return $this;
    }

    /**
     * @param string $placeholder
     * @return $this
     * @throws \Exception
     */
    public function placeholder(string $placeholder)
    {
        if (count($this->options) == 0) {
            throw new \Exception('Options must be set before placeholder in select field '.$this->getName());
        }
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param string $optionText
     * @param string $optionValue
     * @param string $attributes must be passed with a leading space ie " disabled";
     * @return string
     */
    private function getOption(string $optionText, string $optionValue, string $attributes = ''): string
    {
        $selected = $this->getSelectedOptionAttribute($optionValue);
        return "<option value='$optionValue'$selected$attributes>$optionText</option>";
    }

    private function getSelectedOptionAttribute(string $optionValue): string
    {
        if ($this->isOptionSelected($optionValue)) {
            return " selected";
        }
        return "";
    }

    private function isOptionSelected(string $optionValue): bool
    {
        if ($this->selectedOptionValue !== false && $this->selectedOptionValue == $optionValue) {
            return true;
        }
        return false;
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
            if (isset($this->placeholder)) {
                $html .= $this->getOption($this->placeholder, '', ' disabled selected');
            }
            foreach ($this->options as $option_value => $option_text) {
                $html .= $this->getOption((string) $option_text, (string) $option_value);
            }
        }
        return $html;
    }

    public function generate(): string
    {
        if (count($this->options) == 0) {
            throw new \Exception('No options in select field '.$this->getName());
        }
        return parent::generate(true, true, true, true, true, $this->getOptionsHTML());
    }
}
