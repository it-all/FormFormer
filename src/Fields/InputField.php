<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\UserInterfaceHelper;

class InputField extends Field
{
    /** https://www.w3.org/TR/html5/forms.html#states-of-the-type-attribute  */
    const VALID_INPUT_TYPES = ['hidden', 'text', 'search', 'tel', 'url', 'email', 'password', 'date', 'time', 'datetime-local', 'number', 'range', 'color', 'checkbox', 'radio', 'file', 'submit', 'image', 'reset', 'button', 'week', 'month'];

    /**
     * value and type should be set in attributes, if necessary.
     * if not set, browsers will default type to text
     * this should not be instantiated directly for radio and checkbox input fields
     */

    public function __construct(string $label = '', array $attributes = [], string $errorMessage = '', bool $isLabelBefore = true)
    {
        if (isset ($attributes['type']) && !in_array($attributes['type'], self::VALID_INPUT_TYPES)) {
            throw new \Exception('Invalid input type ' . $attributes['type']);
        }

        parent::__construct('input', $label, $attributes, $errorMessage, $isLabelBefore);
    }

    public function getValue(): string
    {
        return (isset($this->attributes['value'])) ? $this->attributes['value'] : '';
    }

    public function generate(): string
    {
        $html = '';
        if ($this->getIsLabelBefore()) {
            $html .= $this->generateDescriptors();
        }
        $html .= UserInterfaceHelper::generateElement($this->tag, $this->attributes, false);
        if (!$this->getIsLabelBefore()) {
            $html .= $this->generateDescriptors();
        }
        return $html;
    }
}
