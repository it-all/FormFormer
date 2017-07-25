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

    /**
     * an error class is not automatically set if $error is true, it can be entered in the $attributes array
     */
    protected function __construct(string $tag = 'input', string $label = '', array $attributes = [], string $errorMessage = '', $isLabelBefore = true)
    {
        $validTags = ['input', 'textarea', 'select', 'button', 'meter', 'output', 'progress', 'datalist'];
        $this->tag = trim($tag);
        if (!in_array($this->tag, $validTags)) {
            throw new \Exception("Invalid tag ".$this->tag);
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
            $this->setAttribute((string) $aName, (string) $aValue);
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
}
