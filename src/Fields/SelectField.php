<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class SelectField extends Field
{
    private $optionsOptionGroups;
//    private $nextOptionKey;

    public function __construct(array $optionsOptionGroups, string $label = '', array $attributes = [], string $errorMessage = '')
    {
        $this->setOptionsOptionGroups($optionsOptionGroups);
//        $this->nextOptionKey = 0;
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

//    public function getNextOptionOptionGroupType()
//    {
//        if (!isset($this->optionsOptionGroups[$this->nextOptionKey])) {
//            return false;
//        }
//
//        return ($this->optionsOptionGroups[$this->nextOptionKey] instanceof SelectOption) ? 'option' : 'group';
//    }
//
//    public function getNextOptionOptionGroup()
//    {
//        $next = $this->optionsOptionGroups[$this->nextOptionKey];
//        $this->nextOptionKey++;
//        return $next;
//    }
}
