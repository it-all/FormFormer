<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use It_All\FormFormer\Factories\FieldsetFactory;

class Form extends NodeHolder
{
    /**
     * whether to denote a required field or an optional field
     * possible values are 'required', 'optional', 'none'. default is 'required'
     */
    static public $alertRequiredOptional;

    /**
     * array of field/field group names => error msgs that are shown at top of form if displayErrorType == 'verbose'
     */
    protected $ffgErrors;

    /**
     * possible values: 'none', 'standard', 'verbose', 'custom'
     * standard displays general msg that form has errors
     * verbose additionally displays individual ffgErrors
     * custom replaces standard msg
     */
    protected $displayErrorType;

    /**
     * @var string used with displayErrorType custom to show message at top of form
     */
    protected $customErrorMsg;

    /**
     * @var  bool
     * if false then fields will not be wrapped with a <div>
     * if true then fields (except hidden fields) will be wrapped with a div.
     */
    static public $divWrapFields;

    /**
     * Form constructor.
     * @param array $attributes
     * @param string $displayErrorType
     * @param string $alertRequiredOptional
     * @param bool $divWrapFields
     */
    function __construct(array $attributes = [], string $displayErrorType = 'verbose', string $alertRequiredOptional = 'required', bool $divWrapFields = true)
    {
        $this->tagName = 'form';
        parent::__construct($attributes);
        $this->displayErrorType = $displayErrorType;
        self::$alertRequiredOptional = $alertRequiredOptional;
        self::$divWrapFields = $divWrapFields;
        $this->ffgErrors = [];
    }

    public function addFieldset(array $attributes = [])
    {
        $fieldset = FieldsetFactory::create($attributes);
        $this->nodes[] = $fieldset;
        return $fieldset;
    }

    /**
     * @param array $ffgNodes
     * @param array $errors
     */
    private function setFfgNodesErrors(array &$ffgNodes, array &$errors)
    {
        foreach ($ffgNodes as $node) {
            if (isset($errors[$node->getName()])) {
                $this->setFfgError($node, $errors[$node->getName()]);
            }
        }
    }

    /**
     * @param array $errors
     * @param array|null $ffgNodes
     * up to client to pass in correct nodes
     */
    public function setFfgErrors(array &$errors, array &$ffgNodes = null)
    {
        $ffgNodes = ($ffgNodes == null) ? $this->getFfgNodes() : $ffgNodes;
        $this->setFfgNodesErrors($ffgNodes, $errors);
    }

    /**
     * @param array $values
     * @param array|null $ffgNodes
     * up to client to pass in correct nodes
     */
    public function setFfgValues(array &$values, array &$ffgNodes = null)
    {
        $ffgNodes = ($ffgNodes == null) ? $this->getFfgNodes() : $ffgNodes;
        $this->setFfgNodesValues($ffgNodes, $values);
    }

    /**
     * @param $node
     * @param $errorMsg
     */
    public function setFfgError($node, $errorMsg)
    {
        $node->setErrorMsg($errorMsg);
        $this->ffgErrors[$node->getName()] = $errorMsg;
    }

    /**
     * @param string $errorMsg
     */
    public function setCustomErrorMsg(string $errorMsg)
    {
        $this->customErrorMsg = $errorMsg;
    }

    /**
     * @return string|false
     */
    private function getCustomErrorMsg()
    {
        if (isset($this->customErrorMsg) && strlen($this->customErrorMsg) > 0) {
            return $this->customErrorMsg;
        }
        return false;
    }

    /**
     *
     */
    public function render()
    {
        echo $this->generate();
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $form = $this->generateOpenTag();
        $form .= $this->generateErrorMsg();
        $form .= $this->generateNodes();
        $form .= $this->generateCloseTag();
        return $form;
    }

    /**
     * @return string
     */
    public function generateErrorMsg(): string
    {
        switch ($this->displayErrorType) {
            case 'none':
                return "";
                break;
            case 'custom':
                if (!$errorMsg = $this->getCustomErrorMsg()) {
                    return "";
                }
                break;
            default:
                if (count($this->ffgErrors) == 0) {
                    return "";
                }
                $pl = (count($this->ffgErrors) > 1) ? "s" : "";
                $errorMsg = "Error$pl encountered";
                if ($this->displayErrorType == 'verbose') {
                    foreach ($this->ffgErrors as $ffgName => $ffgErrorMsg) {
                        $errorMsg .= "<br>$ffgName: $ffgErrorMsg";
                    }
                }
        }
        return "<div id='ffFormError'>$errorMsg</div>";
    }
}
