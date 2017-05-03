<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class OutputField extends Field
{
    protected $tag = 'output';

    public function forattr(string $for)
    {
        $this->setAttribute('for', trim($for));
        return $this;
    }

    public function generate(): string
    {
        return parent::generate(true, false, false, true, true);
    }
}
