<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use It_All\FormFormer\Factories\FieldFactory;
use It_All\FormFormer\Factories\FieldsetFactory;

class Fieldset extends NodeHolder
{
    private $legendText;
    private $legendFields;
    private $fieldsets; // for nesting

    function __construct(array $attributes = [])
    {
        $this->tagName = 'fieldset';
        parent::__construct($attributes);
        $this->legendFields = array();
        $this->fieldsets = array();
    }

    public function addFieldset(array $attributes = [], bool $addToNodes = true)
    {
        $fieldset = FieldsetFactory::create($attributes);
        if ($addToNodes) {
            $this->nodes[] = $fieldset;
        }
        return $fieldset;
    }

    public function legend(string $legendText)
    {
        $this->setLegendText($legendText);
        return $this;
    }

    private function setLegendText(string $legendText)
    {
        $this->legendText = $legendText;
    }

    public function addLegendField(array $fieldInfo)
    {
        $this->legendFields[] = FieldFactory::create($fieldInfo);
    }

    private function getLegendText()
    {
        if (isset($this->legendText)) {
            return $this->legendText;
        }
        return false;
    }

    public function hasLegendFields()
    {
        return (count($this->legendFields) > 0);
    }

    public function getLegendFields()
    {
        return $this->legendFields;
    }

    private function generateLegend(): string
    {
        $legend = "<legend>";
        if ($this->hasLegendFields()) {
            foreach ($this->legendFields as $field) {
                $legend .= $field->generate();
            }
        }
        if ($legendText = $this->getLegendText()) {
            $legend .= $legendText;
        }
        $legend .= "</legend>";
        return $legend;
    }

    public function generate(): string
    {
        if (count($this->nodes) == 0) {
            return "";
        }
        $html = $this->generateOpenTag();
        if ($this->getLegendText() !== false || $this->hasLegendFields()) { // either condition means to insert a legend
            $html .= $this->generateLegend();
        }
        $html .= $this->generateNodes();
        $html .= $this->generateCloseTag();
        return $html;
    }
}
