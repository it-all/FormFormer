<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class TextareaField extends Field
{
    protected $tag = 'textarea';
    private $value = '';

    /**
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
