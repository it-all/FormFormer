<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Form
{
    /** @var  array of Field objects, entered in display order */
    private $fields;

    /** @var  int key to $fields property. set to first field (0) or first field with error */
    private $focusField;

    /** @var string get|post */
    private $method;

    /** @var  bool */
    private $browserValidation;

    /** @var  bool */
    private $error;

    /** @var  string */
    private $errorMessage;


    public function __construct(array $fields, string $method = 'get', bool $browserValidation = true)
    {
        $method = trim(strtolower($method));
        if ($method != 'get' && $method != 'post') {
            throw new \Exception('Method must be get or post: '.$method);
        }

        $this->fields = $fields;
        $this->method = $method;
        $this->browserValidation = $browserValidation;
        $this->focusField = 0;
        $this->error = false;
        $this->errorMessage = '';

        // make sure incoming array are all Field objects
        // on the first field error, set focusField and error properties
        foreach ($this->fields as $fieldKey => $field) {
            if (!($field instanceof Field)) {
                throw new \Exception('Invalid entry in fields array');
            }

            if (!$this->error && $field->getError()) {
                $this->error = true;
                $this->errorMessage = 'Submission Error';
                $this->focusField = $fieldKey;
            }
        }
    }

    public function getFields()
    {
        return $this->fields;
    }

    /** returns string id of focus field or null if no id */
    public function getFocusFieldId()
    {
        return $this->fields[$this->focusField]->getId();
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
