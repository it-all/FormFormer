<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class TextareaField extends Field
{
    protected $tag = 'textarea';
    protected $value;

    function __construct(array $attributes = [], string $label = '', string $descriptor = '', array $customFieldSettings = [])
    {
        if (isset($customFieldSettings['value'])) {
            $this->value = $customFieldSettings['value'];
        } else {
            $this->value = '';
        }
        parent::__construct($attributes, $label, $descriptor);
    }

    /**
     * chaining method
     * @param $value
     * @return $this
     * overrides Field::value to set property instead of attribute
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function generate(): string
    {
        return parent::generate(true, true, true, true, true, $this->value);
    }
}
