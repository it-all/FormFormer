<?php
declare(strict_types=1);

namespace It_All\FormFormer;

abstract class FieldFieldGroup
{
    /** @var bool defaults to false. */
    protected $required;

    /** @var string used also to test ffg error condition */
    protected $errorMsg = "";

    /** @var string output just above each field */
    protected $descriptor = "";

    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * better for client to call Form::setFfgError instead of this as form errors will be set and can be printed at top
     */
    public function setErrorMsg(string $errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    public function hasError(): bool
    {
        return strlen($this->errorMsg > 0);
    }

    /** more efficient to call this than hasError/getErrorMsg */
    public function getErrorMsg()
    {
        if (strlen($this->errorMsg) > 0) {
            return $this->errorMsg;
        } else {
            return false;
        }
    }

    private function isReqdOptEqErrMsg(): bool
    {
        return strtolower($this->errorMsg) == 'required' && $this->getReqdOptText() == 'required';
    }

    private function getReqdOptText(): string
    {
        if ($this->required && Form::$alertRequiredOptional == 'required') {
            return 'required';
        } elseif (!$this->required && Form::$alertRequiredOptional == 'optional') {
            return 'optional';
        }
        return "";
    }

    protected function generateReqdOpt(): string
    {
        $reqdOpt = $this->getReqdOptText();
        if (strlen($reqdOpt) > 0) {
            $spanClass = "ffFieldLabelFine";
            // special case change reqdopt to display red if error message is 'required' and reqdopt is 'required'
            if ($this->isReqdOptEqErrMsg()) {
                $spanClass .= " ffErrorMsg";
            }
            return "<span class='$spanClass'>$reqdOpt</span>";
        }
        return "";
    }

    public function generateErrorMsg(): string
    {
        if (strlen($this->errorMsg) > 0) {
            // special case do not show if error message is 'required' and reqdopt is 'required'
            if ($this->isReqdOptEqErrMsg()) {
                return "";
            }
            return "<span class='ffErrorMsg'>" . $this->errorMsg . "</span>";
        }
        return "";
    }

    protected function generateDescriptor(): string
    {
        if (strlen($this->descriptor) > 0) {
            return "<div class='ffFieldDescriptor'>$this->descriptor</div>";
        }
        return "";
    }

    abstract public function getName();

    abstract protected function generate();

}
