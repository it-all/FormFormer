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
    private $errorMessage;

    /** nodes are validated in form constructor (these will be validated as long as fieldset is added to form)
     * https://www.w3.org/wiki/HTML/Elements/fieldset
     */
    public function __construct(array $nodes, array $attributes = [], bool $hasLegend = false, string $legendText = '', ?CheckboxRadioInputField $legendCheckbox = null, string $errorMessage = '')
    {
        parent::__construct($nodes);
        $this->attributes = $attributes;
        $this->hasLegend = $hasLegend;
        $this->legendText = $legendText;
        $this->legendCheckbox = $legendCheckbox;
        $this->errorMessage = $errorMessage;
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

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function hasError(): bool
    {
        return mb_strlen($this->errorMessage) > 0;
    }

    public function generate(): string
    {
        $html = '<fieldset'.UserInterfaceHelper::generateElementAttributes($this->attributes).'>';

        if ($this->hasLegend || $this->hasError()) {
            $html .= '<legend>';
            if ($this->hasLegend && mb_strlen($this->legendText) > 0) {
                $html .= $this->legendText;
            }
            if ($this->hasLegend && $this->legendCheckbox !== null) {
                $html .= $this->legendCheckbox->generate();
            }
            if ($this->hasError()) {
                $html .= '&nbsp;<span class="ffErrorMsg">'.$this->getErrorMessage().'</span>';
            }
            $html .= '</legend>';
        }

        $html .= $this->generateNodes();

        $html .= '</fieldset>';
        return $html;
    }
}
