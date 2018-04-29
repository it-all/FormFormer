<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Field
{
    protected $tag;
    private $label;
    private $isLabelBefore;
    private $error;
    private $errorMessage;
    protected $attributes;
    const VALID_TAGS = ['input', 'textarea', 'select', 'button', 'meter', 'output', 'progress', 'datalist'];

    /**
     * an error class is not automatically set if $error is true, it can be entered in the $attributes array
     */
    protected function __construct(string $tag = 'input', string $label = '', array $attributes = [], string $errorMessage = '', $isLabelBefore = true)
    {
        $this->tag = trim($tag);
        if (!in_array($this->tag, self::VALID_TAGS)) {
            throw new \Exception("Invalid tag " . $this->tag);
        }

        $this->label = trim($label);
        $this->isLabelBefore = $isLabelBefore;
        $this->errorMessage = trim($errorMessage);
        $this->error = (strlen($this->errorMessage) > 0) ? true : false;
        $this->setAttributes($attributes);
    }

    private function setAttributes(array $attributes)
    {
        $this->attributes = [];

        foreach ($attributes as $aName => $aValue) {
            $this->setAttribute((string)$aName, (string)$aValue);
        }
    }

    protected function setAttribute(string $attributeName, string $attributeValue)
    {
        $this->attributes[strtolower(trim($attributeName))] = trim($attributeValue);
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return '';
    }

    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getIsRequired(): bool
    {
        return isset($this->attributes['required']);
    }

    public function getError(): bool
    {
        return $this->error;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getIsLabelBefore(): bool
    {
        return $this->isLabelBefore;
    }

    protected function generateLabel(): string
    {
        $label = '';
        if (strlen($this->label) > 0) {
            $label .= '<label';
            if (strlen($this->getId()) > 0) {
                $label .= ' for="' . $this->getId() . '"';
            }
            if (!$this->isLabelBefore) {
                $label .= ' class="afterLabel"';
            }
            $label .= '>' . $this->label . '</label>';
        }

        return $label;
    }

    protected function generateErrorAndRequired(): string
    {
        $html = '';
        $showRequired = true;

        if ($this->getError()) {
            if ($this->errorMessage == 'required') {
                $showRequired = false;
            }
            $html .= '<span class="ffErrorMsg">'.$this->errorMessage.'</span>';
        }

        if ($showRequired && $this->getIsRequired()) {
            $html .= '<span class="fieldRequired">required</span>';
        }

        return $html;
    }

    protected function generateDescriptors(): string
    {
        return $this->generateLabel().$this->generateErrorAndRequired();
    }

    public function generate(): string
    {
        $html = '';
        if ($this->isLabelBefore) {
            $html .= $this->generateDescriptors();
        }
        $html .= UserInterfaceHelper::generateElement($this->tag, $this->attributes);
        if (!$this->isLabelBefore) {
            $html .= $this->generateDescriptors();
        }
        return $html;
    }
}
