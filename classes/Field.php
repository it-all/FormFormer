<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Field extends FieldFieldGroup
{
    /**
     * @var string the html element tag name, either input, button, select or textarea
     */
    protected $tag = null;

    /** @var array of html element (tag) attribute: name => value */
    protected $attributes;

    /** @var string optional field descriptor */
    protected $descriptor;

    protected $label;

    function __construct(array $attributes = [], string $label = '', string $descriptor = '')
    {
        $this->attributes = [];
        // important to not just assign $this->attributes since the required attribute will set the required property
        foreach ($attributes as $aName => $aVal) {
            $this->setAttribute($aName, $aVal);
        }
        $this->label = $label;
        $this->descriptor = $descriptor;
    }

    public function label(string $label)
    {
        $this->label = trim($label);
        return $this;
    }

    /**
     * @param string $attrName
     * @param string|null $attrValue if null set to attrName
     * @return $this
     */
    public function attr(string $attrName, string $attrValue = null)
    {
        if ($attrValue === null) {
            $attrValue = $attrName;
        }
        $this->setAttribute(trim($attrName), trim($attrValue));
        return $this;
    }

    public function name(string $name)
    {
        $this->setAttribute('name', trim($name));
        return $this;
    }

    /**
     * @param string $form
     * @return $this
     * associate field with form id
     */
    public function form(string $formId)
    {
        $this->setAttribute('form', trim($formId));
        return $this;
    }

    public function tab(int $tabIndex)
    {
        $this->setAttribute('tabindex', $tabIndex);
        return $this;
    }

    public function id(string $id)
    {
        $this->setAttribute('id', trim($id));
        return $this;
    }

    public function title(string $title)
    {
        $this->setAttribute('title', trim($title));
        return $this;
    }

    /**
     * @param $value do not type hint as some fields will send strings and others floats or ints.
     * this is simply an attribute, not a field property
     * cannot trim as can only trim strings
     * @return $this
     */
    public function value($value)
    {
        $this->setAttribute('value', $value);
        return $this;
    }

    public function desc(string $descriptor)
    {
        $this->descriptor = trim($descriptor);
        return $this;
    }

    public function setErrorMsg(string $errorMsg)
    {
        $this->setAttribute('class', 'ffFieldError');
        parent::setErrorMsg($errorMsg);
    }

    // do not type hint value as may be string/int/float
    protected function setAttribute(string $attributeName, $attributeValue)
    {
        $this->attributes[$attributeName] = $attributeValue;
        if ($attributeName == 'required') {
            $this->required = true;
        }
    }

    public function getAttributeByName(string $attributeName)
    {
        return Helper::getAttributeByName($this->attributes, $attributeName);
    }

    protected function removeAttribute(string $attributeName)
    {
        if (isset($this->attributes[$attributeName])) {
            unset($this->attributes[$attributeName]);
            if ($attributeName == 'required') {
                $this->required = false;
            }
        }
    }

    public function getId()
    {
        if (isset($this->attributes['id'])) {
            return $this->attributes['id'];
        }
        return null;
    }

    public function getName()
    {
        if (isset($this->attributes['name'])) {
            return $this->attributes['name'];
        }
        return null;
    }

    public function getValue()
    {
        if (isset($this->attributes['value'])) {
            return $this->attributes['value'];
        }
        return null;
    }

    private function generateLabel()
    {
        if (strlen($this->label) > 0) {
            $html = "<label";
            if ($this->getId() !== null) {
                $html .= " for='".$this->getId()."'";
            }
            $html .= ">$this->label</label>";
            return $html;
        }
        return "";
    }

    public function generate(bool $showLabel = true, bool $showReqdOpt = true, bool $showErrorMsg = true, bool $showDescriptor = true, bool $divWrap = true, string $content = '', bool $endTag = false, string $postFieldContent = '')
    {
//        echo '<pre>';var_dump($this);echo '</pre><br><br>';
        $html = "";
        if ($showLabel || $showReqdOpt) {
            $html .= "<div class='ffLabelDiv'>";
            if ($showLabel) {
                $html .= $this->generateLabel();
            }
            if ($showReqdOpt) {
                $html .= $this->generateReqdOpt();
            }
            $html .= "</div>";
        }
        if ($showDescriptor) {
            $html .= $this->generateDescriptor();
        }
        $html .= "<".$this->tag.Helper::generateTagAttributes($this->attributes).">";
        if (strlen($content) > 0) {
            $html .= $content;
        }
        if ($endTag) {
            $html .= "</".$this->tag.">";
        }
        if (strlen($postFieldContent) > 0) {
            $html .= $postFieldContent;
        }
        if ($showErrorMsg) {
            $html .= $this->generateErrorMsg();
        }
        if (Form::$divWrapFields && $divWrap) {
            $html = "<div class='ffFieldWrapper'>$html</div>";
        }
        return $html;
    }
}
