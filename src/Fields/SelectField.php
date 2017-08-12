<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class SelectField extends Field
{
    private $optionsOptionGroups;
    private $selectedValue;

    public function __construct(array $optionsOptionGroups, string $selectedValue = '', string $label = '', array $attributes = [], string $errorMessage = '')
    {
        $this->setOptionsOptionGroups($optionsOptionGroups);
        $this->selectedValue = $selectedValue;
        parent::__construct('select', $label, $attributes, $errorMessage);
    }

    private function setOptionsOptionGroups(array $optionsOptionGroups)
    {
        foreach ($optionsOptionGroups as $optionsOptionGroup) {
            if (!($optionsOptionGroup instanceof SelectOption) && !($optionsOptionGroup instanceof SelectOptionGroup)) {
                throw new \Exception('Invalid Option or Option Group');
            }
        }

        $this->optionsOptionGroups = $optionsOptionGroups;
    }

    public function getOptionOptionGroups(): array
    {
        return $this->optionsOptionGroups;
    }

    public function getSelectedValue(): string
    {
        return $this->selectedValue;
    }

    // put in for compatibility with input and textarea fields
    public function getValue(): string
    {
        return $this->getSelectedValue();
    }
}
