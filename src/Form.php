<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Form extends NodeHolder
{
    /** @var  string. set to first field or first field with error */
    private $focusFieldId;

    /** @var  bool */
    private $error;

    /** @var  string */
    private $errorMessage;

    /** @var array  */
    private $attributes;


    public function __construct(array $nodes, array $attributes = [])
    {
        $this->attributes = $attributes;
        parent::__construct($nodes);
        $this->error = false;
        $this->errorMessage = '';

        $this->setErrorAndFocusField($nodes);
    }

    // also validates incoming array to be Field or Fieldset objects
    // on the first field error, set focusField and error properties
    // recursive when encounters a fieldset
    private function setErrorAndFocusField(array $nodes)
    {
        foreach ($nodes as $nodeKey => $node) {
            if (!($node instanceof Field) && !($node instanceof Fieldset)) {
                throw new \Exception('Invalid node');
            }

            if ($node instanceof Field) {
                if (!isset($this->focusFieldId)) {
                    $this->focusFieldId = $node->getId();
                }

                if (!$this->error && $node->getError()) {
                    $this->error = true;
                    $this->errorMessage = 'Submission Error';
                    $this->focusFieldId = $node->getId();
                }

            } else {
                // Fieldset
                if (!$this->error) {
                    $this->setErrorAndFocusField($node->getNodes());
                }
            }

        }
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

    public function getError()
    {
        return $this->error;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
