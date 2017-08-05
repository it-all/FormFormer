<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class MeterProgressField extends Field
{
    private $content;

    public function __construct(string $which = 'meter', string $label = '', string $content = '', array $attributes = [], string $errorMessage = '')
    {
        if ($which != 'meter' && $which != 'progress') {
            throw new \Exception("Type must be meter or progress, not: $which");
        }
        $this->content = $content;
        parent::__construct($which, $label, $attributes, $errorMessage);
    }

    public function getContent()
    {
        return $this->content;
    }
}
