<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\UserInterfaceHelper;

class DatalistField extends Field
{
    private $options;

    public function __construct(array $options, array $attributes = [], string $errorMessage = '')
    {
        $this->options = $options;
        parent::__construct('datalist', '', $attributes, $errorMessage); // no label
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    private function generateOptions(): string
    {
        $options = '';
        foreach ($this->options as $optionValue) {
            $options .= UserInterfaceHelper::generateElement('option', [], true, $optionValue);
        }
        return $options;
    }

    public function generate(): string
    {
        $html = $this->generateDescriptors();
        $html .= UserInterfaceHelper::generateElement($this->tag, $this->attributes, true, $this->generateOptions(), false);
        return $html;
    }
}
