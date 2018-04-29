<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use It_All\FormFormer\Fields\InputFields\CheckboxRadioInputField;

class Fieldset extends NodeHolder
{
    private $attributes;
    private $hasLegend;
    private $legendText;
    private $legendCheckbox;

    /** nodes are validated in form constructor (these will be validated as long as fieldset is added to form)
     * https://www.w3.org/wiki/HTML/Elements/fieldset
     */
    public function __construct(array $nodes, array $attributes = [], bool $hasLegend = false, string $legendText = '', CheckboxRadioInputField $legendCheckbox = null)
    {
        parent::__construct($nodes);
        $this->attributes = $attributes;
        $this->hasLegend = $hasLegend;
        $this->legendText = $legendText;
        $this->legendCheckbox = $legendCheckbox;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasLegend(): bool
    {
        return $this->hasLegend;
    }

    public function getLegendText(): string
    {
        return $this->legendText;
    }

    public function hasCheckbox(): bool
    {
        return $this->legendCheckbox != null;
    }

    public function getCheckbox(): ?CheckboxRadioInputField
    {
        return $this->legendCheckbox;
    }

    public function generate(): string
    {
        $html = '<fieldset'.UserInterfaceHelper::generateElementAttributes($this->attributes).'>';

        if ($this->hasLegend) {
            $html .= '<legend>';
            if (strlen($this->legendText) > 0) {
                $html .= $this->legendText;
            }
            if ($this->legendCheckbox !== null) {
                $html .= $this->legendCheckbox->generate();
            }
            $html .= '</legend>';
        }

        $html .= $this->generateNodes();

        $html .= '</fieldset>';
        return $html;
    }
}
