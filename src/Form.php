<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Form extends NodeHolder
{
    /** @var  string. set to first field or first field with error */
    private $focusFieldId;

    /** @var string get|post */
    private $method;

    /** @var  bool */
    private $browserValidation;

    /** @var  bool */
    private $error;

    /** @var  string */
    private $errorMessage;


    public function __construct(array $nodes, string $method = 'get', bool $browserValidation = true)
    {
        $method = trim(strtolower($method));
        if ($method != 'get' && $method != 'post') {
            throw new \Exception('Method must be get or post: '.$method);
        }

        parent::__construct($nodes);
        $this->method = $method;
        $this->browserValidation = $browserValidation;
        $this->error = false;
        $this->errorMessage = '';

        $this->setErrorAndFocusField($nodes);

//        // make sure incoming array are all Field or Fieldset objects
//        // on the first field error, set focusField and error properties
//        foreach ($this->nodes as $nodeKey => $node) {
//            if (!($node instanceof Field) && !($node instanceof Fieldset)) {
//                throw new \Exception('Invalid entry in fields array');
//            }
//
//            if ($node instanceof Field) {
//                if (!isset($this->focusFieldId)) {
//                    $this->focusFieldId = $node->getId();
//                }
//
//                if (!$this->error && $node->getError()) {
//                    $this->error = true;
//                    $this->errorMessage = 'Submission Error';
//                    $this->focusFieldId = $node->getId();
//                }
//
//            } else {
//                // Fieldset
//                if (!$this->error) {
//                    $fieldsetNodes = $node->getNodes();
//                }
//            }
//
//        }
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

    public function getMethod()
    {
        return $this->method;
    }

    public function getBrowserValidation()
    {
        return $this->browserValidation;
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
