<?php
declare(strict_types=1);

namespace It_All\FormFormer\Factories;

class FieldGroupFactory
{

    public static function create(string $type, string $name, string $label = '', string $descriptor = '', bool $required = false)
    {
        $validTypes = array('checkbox', 'file', 'radio');
        if (!in_array($type, $validTypes)) {
            throw new \Exception("invalid field group type $type for $name");
        }
        $classname = ucwords($type).'FieldGroup';
        $namespaceClass = "It_All\\FormFormer\\Fields\\FieldGroups\\".$classname;
        $fieldGroup = new $namespaceClass($type, $name, $label, $descriptor, $required);
        return $fieldGroup;
    }
}
