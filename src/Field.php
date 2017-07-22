<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Field
{
    protected $tag; // input, textarea, select, etc
    private $id;
    private $name;
    private $label;
    protected $value;
    private $error;
    private $errorMessage;
    protected $attributes;

    /** otherAttributes should not include id, name, value, class
    * an error class is not automatically set even if $error is true, it can be entered in the $cssClasses array
     */
    public function __construct(string $tag = 'input', string $id = '', string $name = '', string $label = '', string $value = '', bool $required = false, array $cssClasses = null, array $otherAttributes = null, string $errorMessage = '')
    {
        $validTags = ['input', 'textarea', 'select', 'button', 'meter', 'output', 'progress'];
        $this->tag = trim($tag);
        if (!in_array($this->tag, $validTags)) {
            throw new \Exception("Invalid tag ".$this->tag);
        }

        $this->id = trim($id);
        $this->name = trim($name);
        $this->label = trim($label);
        $this->value = trim($value);
        $this->errorMessage = trim($errorMessage);
        $this->error = (strlen($this->errorMessage) > 0) ? true : false;
        $this->setAttributes($id, $name, $required, $cssClasses, $otherAttributes);
    }

    /** note if value is a field attribute it is set in the child class */
    private function setAttributes(string $id = null, string $name = null, bool $required = false, array $cssClasses = null, array $otherAttributes = null)
    {
        $this->attributes = [];

        if ($id !== null && strlen($id) > 0) {
            $this->setAttribute('id', $id);
        }

        if ($name !== null && strlen($name) > 0) {
            $this->setAttribute('name', $name);
        }

        if ($required) {
            $this->setAttribute('required', 'required');
        }

        if (is_array($cssClasses)) {
            $classAttributeValue = '';
            foreach ($cssClasses as $index => $class) {
                if ($index > 0) {
                    $classAttributeValue .= ' ';
                }
                $classAttributeValue .= $class;
            }
            $this->setAttribute('class', $classAttributeValue);
        }

        if (is_array($otherAttributes)) {
            $weedOut = ['id', 'name', 'value', 'class']; // these should be set elsewhere in the constructor
            foreach ($otherAttributes as $aName => $aValue) {
                if (!in_array($aName, $weedOut)) {
                    $this->setAttribute((string) $aName, (string) $aValue);
                }
            }
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return false;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
