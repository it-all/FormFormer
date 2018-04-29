<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Form extends NodeHolder
{
    /** @var array  */
    private $attributes;

    /** @var  string. set to first field or first field with error. note, can also be '' if no field errors and all fields have values */
    private $focusFieldId;

    /** @var  string */
    private $errorMessage;

    /** @var array can be used to display specific errors at the top in case of long form */
    private $fieldErrorMessages;

    const GENERAL_ERROR_MESSAGE = 'Submission Error';

    /** Sending a non-empty $errorMessage causes an error to display, even if there are no field errors, and overrides the GENERAL_ERROR_MESSAGE
     * nodes within fieldset nodes are not independent form nodes
     */
    public function __construct(array $nodes, array $attributes = [], string $errorMessage = '')
    {
        $this->attributes = $attributes;
        parent::__construct($nodes);

        // initialize properties
        $this->focusFieldId = '';
        $this->errorMessage = '';
        $this->fieldErrorMessages = [];

        $this->setFieldErrorsAndFocus($nodes);
        if (strlen($errorMessage) > 0) {
            $this->errorMessage = $errorMessage;
        }

    }

    // also validates incoming array to be Field or Fieldset objects
    // focusField set to first field without value if exists
    // on the first field error, set focusField (overwrite if already set) and error properties
    // recursive when encounters a fieldset
    private function setFieldErrorsAndFocus(array $nodes)
    {
        foreach ($nodes as $nodeKey => $node) {
            if (!($node instanceof Field) && !($node instanceof Fieldset)) {
                throw new \Exception('Invalid node');
            }

            if ($node instanceof Field) {
                if (method_exists($node, 'getValue') && strlen($node->getValue()) == 0 && strlen($this->focusFieldId) == 0) {
                    $this->focusFieldId = $node->getId();
                }

                if ($node->getError()) {
                    $this->fieldErrorMessages[] = $node->getErrorMessage();
                    if (!$this->hasError()) {
                        $this->errorMessage = self::GENERAL_ERROR_MESSAGE;
                        $this->focusFieldId = $node->getId();
                    }
                }

            } else {
                // Fieldset
                if (!$this->hasError()) {
                    $this->setFieldErrorsAndFocus($node->getNodes());
                }
            }
        }
    }

    public function hasError(): bool
    {
        return strlen($this->errorMessage) > 0;
    }

    /** returns string id of focus field or '' if no id */
    public function getFocusFieldId(): string
    {
        return $this->focusFieldId;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getFieldErrorMessages(): array
    {
        return $this->fieldErrorMessages;
    }

    public function generate(): string
    {
        $html = '<form'.UserInterfaceHelper::generateElementAttributes($this->attributes).'>';

        if ($this->hasError()) {
           $html .= '<div class="generalFormError">'.$this->getErrorMessage().'</div>';
        }

        $html .= $this->generateNodes();
        $html .= '</form>';

        return $html;
    }

}
