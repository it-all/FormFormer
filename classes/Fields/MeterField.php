<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class MeterField extends Field
{
    protected $tag = 'meter';

    function __construct(array $attributes = [], string $label = '', string $descriptor = '')
    {
        parent::__construct($attributes, $label, $descriptor);
    }

    public function min(float $min)
    {
        $this->setAttribute('min', (string) $min);
        return $this;
    }

    public function max(float $max)
    {
        $this->setAttribute('max', (string) $max);
        return $this;
    }

    public function low(float $low)
    {
        $this->setAttribute('low', (string) $low);
        return $this;
    }

    public function high(float $high)
    {
        $this->setAttribute('high', (string) $high);
        return $this;
    }

    public function optimum(float $optimum)
    {
        $this->setAttribute('optimum', (string) $optimum);
        return $this;
    }

    public function generate(): string
    {
        if (!isset($this->attributes['value'])) {
            throw new \Exception('the value attribute must be defined for meter fields');
        }
        return parent::generate(true, false, false, true, true);
    }
}
