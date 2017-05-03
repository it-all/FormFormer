<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\FieldGroups;

use It_All\FormFormer\Factories\FieldFactory;
use It_All\FormFormer\FieldGroup;

abstract class RadioCheckboxFieldGroup extends FieldGroup
{
    private $choices;
    private $choicesChecked = [];

    /**
     * @param array $choicesIn
     * either [choiceText => choiceValue, ...]
     * or [choiceText => [choiceValue, [bool checked]], ...]
     * note only 1 can be checked in the field group but not validating for more than one checked here
     * @return $this
     */
    public function choices(array $choicesIn)
    {
        $choices = [];
        $checkedChoices = [];
        foreach ($choicesIn as $choiceText => $choiceInfo) {
            if (is_array($choiceInfo)) {
                $choiceValue = $choiceInfo[0];
                if (isset($choiceInfo[1]) && $choiceInfo[1]) {
                    $checkedChoices[] = $choiceValue;
                }
            } else {
                $choiceValue = $choiceInfo;
            }
            $choices[$choiceText] = $choiceValue;
        }
        if (count($checkedChoices) > 0) {
            $this->setChoicesChecked($checkedChoices);
        }
        $this->setChoices($choices);
        return $this;
    }

    private function setChoices(array $choices)
    {
        $this->choices = $choices;
        $this->addFields();
    }

    private function setChoicesChecked(array $choicesChecked)
    {
        $this->choicesChecked = $choicesChecked;
        return $this;
    }

    protected function addFields()
    {
        $attributes = $this->getFieldAttributes();
        foreach ($this->choices as $fieldText => $fieldValue) {
            unset($attributes['checked']);
            $attributes['value'] = $fieldValue;
            if (in_array($fieldValue, $this->choicesChecked)) {
                $attributes['checked'] = 'checked';
            }
            $field = FieldFactory::create('input', $attributes);
            $field->text((string) $fieldText);
            $this->addField($field);
        }
    }
}
