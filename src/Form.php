<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Form extends NodeHolder
{
    /** @var  string. set to first field or first field with error */
    private $focusFieldId;

    /** @var array  */
    private $attributes;

    /** @var  string */
    private $errorMessage;

    /** @var array can be used to display specific errors at the top in case of long form */
    private $fieldErrorMessages;

    const GENERAL_ERROR_MESSAGE = 'Submission Error';

    /** Sending a non-empty $errorMessage causes an error to display, even if there are no field errors, and overrides the GENERAL_ERROR_MESSAGE
     *
     */
    public function __construct(array $nodes, array $attributes = [], string $errorMessage = '')
    {
        $this->attributes = $attributes;
        parent::__construct($nodes);
        $this->errorMessage = ''; // initialize
        $this->fieldErrorMessages = []; // initialize

        $this->setFieldErrorsAndFocus($nodes);
        if (strlen($errorMessage) > 0) {
            $this->errorMessage = $errorMessage;
        }

    }

    // also validates incoming array to be Field or Fieldset objects
    // on the first field error, set focusField and error properties
    // recursive when encounters a fieldset
    private function setFieldErrorsAndFocus(array $nodes)
    {
        foreach ($nodes as $nodeKey => $node) {
            if (!($node instanceof Field) && !($node instanceof Fieldset)) {
                throw new \Exception('Invalid node');
            }

            if ($node instanceof Field) {
                if (!isset($this->focusFieldId)) {
                    $this->focusFieldId = $node->getId();
                }

                if ($node->getError()) {
                    $this->$fieldErrorMessages[] = $node->getErrorMessage();
                    if (!$this->hasError()) {
                        $this->errorMessage = self::GENERAL_ERROR_MESSAGE;
                        $this->focusFieldId = $node->getId();
                    }
                }
//                if (!$this->hasError() && $node->getError()) {
//                    $this->errorMessage = self::GENERAL_ERROR_MESSAGE;
//                    $this->focusFieldId = $node->getId();
//                }

            } else {
                // Fieldset
                if (!$this->hasError()) {
                    $this->setFieldErrorsAndFocus($node->getNodes());
                }
            }

        }
    }

    public function hasError()
    {
        return strlen($this->errorMessage) > 0;
    }

    /** returns string id of focus field or '' if no id */
    public function getFocusFieldId(): string
    {
        return $this->focusFieldId;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getFieldErrorMesssages()
    {
        return $this->fieldErrorMessages;
    }
}
