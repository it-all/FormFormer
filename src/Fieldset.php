<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use It_All\FormFormer\Fields\InputFields\CheckboxInputField;

class Fieldset extends NodeHolder
{
    public $isFieldset = true; // for twig
    private $legendText;
    private $attributes;
    private $checkbox;

    /** nodes are validated in form constructor (these will be validated as long as fieldset is added to form)
     * https://www.w3.org/wiki/HTML/Elements/fieldset
     */
    public function __construct(array $nodes, string $legendText='', array $attributes = [], CheckboxInputField $checkbox = null)
    {
        parent::__construct($nodes);
        $this->legendText = $legendText;
        $this->attributes = $attributes;
        $this->checkbox = $checkbox;
    }

    public function getLegendText(): string
    {
        return $this->legendText;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getCheckbox()
    {
        return $this->checkbox;
    }
}
