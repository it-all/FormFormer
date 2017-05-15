<?php
declare(strict_types=1);

namespace It_All\FormFormer;
use It_All\FormFormer\Factories\FieldFactory;
use It_All\FormFormer\Factories\FieldGroupFactory;
use It_All\FormFormer\Fields\SelectField;

/**
* nodes are the building blocks of forms (and other NodeHolders --> Fieldsets)
*/
abstract class NodeHolder
{
    /** @var  the html element tag */
    protected $tagName;

    /**
     * array. the building blocks of forms
     * includes top level Field, FieldGroup, and Fieldset objects
     * but not Fields within FieldGroups. or Fields, FieldGroups, and other Fieldsets within Fieldsets
     */
    protected $nodes; // Field objects, FieldGroup objects, Fieldset objects (top level only, not nested fieldsets), and html strings

    /** @var array of html element (tag) attribute: name => value */
    protected $attributes;

    function __construct(array $attributes = [])
    {
        $this->nodes = [];
        $this->attributes = $attributes;
    }

    /**
     * @param string $attributeName
     * @param string $attributeValue
     * do not type hint value as may be string/int/float
     */
    public function setAttribute(string $attributeName, $attributeValue)
    {
        $this->attributes[$attributeName] = $attributeValue;
    }

    public function getAttributeByName(string $attributeName)
    {
        return Helper::getAttributeByName($this->attributes, $attributeName);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $html
     */
    public function addHtml(string $html)
    {
        $this->nodes[] = $html;
    }

    public function addFieldGroup(string $type, string $name, string $label = '', string $descriptor = '', bool $required = false, array $customFieldSettings = [])
    {
        $fg = FieldGroupFactory::create(trim($type), trim($name), trim($label), trim($descriptor), $required, $customFieldSettings);
        $this->nodes[] = $fg;
        return $fg;
    }

    public function addField(string $tag = 'input', array $attributes = [], string $label = '', string $descriptor = '', array $customFieldSettings = [])
    {
//        $factoryClass = "It_All\\FormFormer\\Factories\\".ucwords($tag)."FieldFactory";
//        $field = $factoryClass::create($attributes, trim($label), trim($descriptor), $customFieldSettings);
        $field = FieldFactory::create($tag, $attributes, trim($label), trim($descriptor), $customFieldSettings);
        $this->nodes[] = $field;
        return $field;
    }

    /**
     * basically a shorthand version of addField()
     * @param string $element
     * @param string $type
     * @return mixed
     */
    public function field(string $element = 'input', string $type = 'text')
    {
        // special case if type is input as blank string do not include as an attribute
        $attrArr = (trim($type) == '') ? [] : ['type' => $type];
        return $this->addField($element, $attrArr);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @return array
     */
    public function getFfgNodes(): array
    {
        $ffgNodes = array();
        foreach ($this->getNodes() as $node) {
            if (is_object($node)) {
                if ($node instanceof FieldFieldGroup) {
                    $ffgNodes[] = $node;
                } else {
                    // fieldset
                    $node->getFfgNodes();
                }
            }
        }
        return $ffgNodes;
    }

    /**
     * @param string $fieldGroupName
     * @return bool|mixed
     */
    public function getFieldGroupByName(string $fieldGroupName)
    {
        foreach ($this->nodes as $node) {
            if (is_object($node)) {
                if ($node instanceof Fieldset) {
                    // drill down into fieldset nodes
                    if ($xnode = $node->getFieldGroupByName($fieldGroupName)) {
                        return $xnode;
                    }
                } elseif ($node instanceof FieldGroup) {
                    if ($node->getName() == $fieldGroupName) {
                        return $node;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param string $fieldName
     * @return bool|mixed
     */
    public function getFieldByName(string $fieldName)
    {
        foreach ($this->nodes as $node) {
            if (is_object($node)) {
                if ($node instanceof Fieldset) {
                    // drill down into fieldset nodes
                    if ($xnode = $node->getFieldByName($fieldName)) {
                        return $xnode;
                    }
                } elseif ($node instanceof Field) {
                    if ($node->getName() == $fieldName) {
                        return $node;
                    }
                }
            }
        }
        return false;
    }

    abstract public function generate(): string;

    /**
     * @return string
     * use in order to generate form piecemeal
     */
    public function generateOpenTag(): string
    {
        $attributes = (count($this->attributes) > 0) ? Helper::generateTagAttributes($this->attributes) : "";
        return "<$this->tagName$attributes>";
    }

    /**
     * @return string
     */
    protected function generateNodes()
    {
        $nodes_html = "";
        foreach ($this->nodes as $node) {
            if (is_object($node)) {
                $nodes_html .= $node->generate();
            } else { // node is html block
                $nodes_html .= "<div class='ffHtmlWrapper'>$node</div>";
            }
        }
        return $nodes_html;
    }

    /**
     * @return string
     * use in order to generate form piecemeal
     */
    public function generateCloseTag(): string
    {
        return "</$this->tagName>";
    }


}
