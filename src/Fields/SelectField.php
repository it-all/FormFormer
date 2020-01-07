<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\UserInterfaceHelper;

class SelectField extends Field
{
    private $optionsOptionGroups;
    private $selectedValue;

    /**
     * if $selectedValue is null then selected will not be set for any option (the browser may select the first non-disabled option by default)
     */
    public function __construct(array $optionsOptionGroups, ?string $selectedValue = null, string $label = '', array $attributes = [], string $errorMessage = '', bool $isLabelBefore = true, bool $squelchRequired = false)
    {
        $this->setOptionsOptionGroups($optionsOptionGroups);
        $this->selectedValue = $selectedValue;
        parent::__construct('select', $label, $attributes, $errorMessage, $isLabelBefore, $squelchRequired);
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

    public function getSelectedValue(): ?string
    {
        return $this->selectedValue;
    }

    // put in for compatibility with input and textarea fields
    public function getValue(): string
    {
        return ($this->getSelectedValue() === null) ? '' : $this->getSelectedValue();
    }

    private function generateOptionsOptionGroups(): string
    {
        $html = '';
        foreach ($this->optionsOptionGroups as $optionOptionGroup) {
            $html .= $optionOptionGroup->generate($this->selectedValue);
        }
        return $html;
    }

    public function generate(): string
    {
        $html = $this->generateLabel();
        $html .= $this->generateErrorAndRequired();
        $html .= UserInterfaceHelper::generateElement($this->tag, $this->attributes, true, $this->generateOptionsOptionGroups(), false);
        return $html;
    }
}
