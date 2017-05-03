<?php
declare(strict_types=1);

namespace It_All\FormFormer\Factories;

use It_All\FormFormer\Fieldset;

class FieldsetFactory
{
    public static function create(array $attributes = [])
    {
        return new Fieldset($attributes);
    }
}
