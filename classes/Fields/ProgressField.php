<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;

class ProgressField extends Field
{
    protected $tag = 'progress';

    public function generate(): string
    {
        return parent::generate(true, false, false, true, true);
    }
}
