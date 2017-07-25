<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

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
}
