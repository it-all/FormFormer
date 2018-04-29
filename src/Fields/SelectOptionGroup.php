<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\UserInterfaceHelper;

class SelectOptionGroup
{
    private $options;
    private $attributes;

    public function __construct(array $options, string $label = '')
    {
        $this->setOptions($options);
        $this->setAttributes($label);
    }

    private function setOptions(array $options)
    {
        foreach ($options as $option) {
            if (!($option instanceof SelectOption)) {
                throw new \Exception('Invalid option');
            }
        }
        $this->options = $options;
    }

    private function setAttributes(string $label)
    {
        $this->attributes = [];
        if (strlen($label) > 0) {
            $this->attributes['label'] = $label;
        }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    private function generateOptions(string $selectedValue = ''): string
    {
        $html = '';
        foreach ($this->options as $option) {
            $html .= $option->generate($selectedValue);
        }
        return $html;
    }

    public function generate(string $selectedValue = ''): string
    {
        return UserInterfaceHelper::generateElement('optgroup', $this->attributes, true, $this->generateOptions($selectedValue));
    }
}
