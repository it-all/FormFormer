<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class TextareaField extends Field
{
    protected $tag = 'textarea';
    private $value;

    function __construct(array $fieldInfo)
    {
        parent::__construct($fieldInfo);
        if (isset($fieldInfo['value'])) {
            $this->value = $fieldInfo['value'];
            $this->initialValue = $fieldInfo['value'];
        } else {
            $this->value = null;
        }
    }

    public function setValue($value)
    {
        $this->value = $value;
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
