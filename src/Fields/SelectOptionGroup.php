<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

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
}
