<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\FieldGroups;

use It_All\FormFormer\Factories\FieldFactory;
use It_All\FormFormer\FieldGroup;

class FileFieldGroup extends FieldGroup
{
    private $numFiles;

    public function num(int $numFiles)
    {
        $this->numFiles = $numFiles;
        $this->addFields();
    }

    protected function addFields()
    {
        $attributes = $this->getFieldAttributes();
        for ($fieldCount = 1; $fieldCount <= $this->numFiles; ++$fieldCount) {
            $this->addField(FieldFactory::create('input', $attributes));
        }
    }
}
