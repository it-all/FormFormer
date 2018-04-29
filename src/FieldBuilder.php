<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use It_All\FormFormer\Fields\DatalistField;
use It_All\FormFormer\Fields\InputField;
use It_All\FormFormer\Fields\InputFields\CheckboxRadioInputField;
use It_All\FormFormer\Fields\MeterProgressField;
use It_All\FormFormer\Fields\OutputField;
use It_All\FormFormer\Fields\SelectField;
use It_All\FormFormer\Fields\TextareaField;

/** inspired by https://blog.joefallon.net/2015/08/immutable-objects-in-php/ */

class FieldBuilder
{

    private $tag;
    private $label;
    private $attributes;
    private $errorMessage;
    private $datalistOptions;
    private $meterProgressContent;
    private $outputValue;
    private $selectOptionsOptionGroups;
    private $selectSelectedValue;
    private $textareaValue;

    public function __construct()
    {
        $this->initializeProperties();
    }

    private function initializeProperties()
    {
        $this->tag = 'input';
        $this->label = '';
        $this->attributes = [];
        $this->errorMessage = '';
        $this->datalistOptions = [];
        $this->meterProgressContent = '';
        $this->outputValue = '';
        $this->selectOptionsOptionGroups = [];
        $this->selectSelectedValue = '';
        $this->textareaValue = '';
    }

    public function tag(string $tag = 'input')
    {
        $this->tag = trim($tag);
        if (!in_array($this->tag, Field::VALID_TAGS)) {
            throw new \Exception("Invalid tag ".$this->tag);
        }
        return $this;
    }

    public function label(string $label, bool $trim = true)
    {
        $this->label = ($trim) ? trim($label) : $label;
        return $this;
    }

    public function attr(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function err(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function dlOpt(array $datalistOptions)
    {
        $this->datalistOptions = $datalistOptions;
        return $this;
    }

    public function mpContent(string $meterProgressContent, bool $trim = true)
    {
        $this->meterProgressContent =  ($trim) ? trim($meterProgressContent) : $meterProgressContent;
        return $this;
    }

    public function oVal(string $outputValue, bool $trim = true)
    {
        $this->outputValue =  ($trim) ? trim($outputValue) : $outputValue;
        return $this;
    }

    public function selOpt(array $selectOptionsOptionGroups)
    {
        $this->selectOptionsOptionGroups = $selectOptionsOptionGroups;
        return $this;
    }

    public function selVal(string $selectSelectedValue, bool $trim = true)
    {
        $this->selectSelectedValue =  ($trim) ? trim($selectSelectedValue) : $selectSelectedValue;
        return $this;
    }

    public function textVal(string $textareaValue, bool $trim = true)
    {
        $this->textareaValue =  ($trim) ? trim($textareaValue) : $textareaValue;
        return $this;
    }

    private function isCheckboxOrRadioInput()
    {
        return isset($this->attributes['type']) && ($this->attributes['type'] == 'checkbox' || $this->attributes['type'] == 'radio');
    }

    public function build()
    {

        switch ($this->tag) {

            case 'datalist':
                if (count($this->datalistOptions) == 0) {
                    throw new \Exception('datalist options must be set');
                }
                $field = new DatalistField($this->datalistOptions, $this->attributes, $this->errorMessage);
                break;

            case 'meter':
            case 'progress':
                $field = new MeterProgressField($this->tag, $this->meterProgressContent, $this->label, $this->attributes, $this->errorMessage);
                break;

            case 'output':
                $field = new OutputField($this->outputValue, $this->label, $this->attributes, $this->errorMessage);
                break;

            case 'select':
                if (count($this->selectOptionsOptionGroups) == 0) {
                    throw new \Exception('select options must be set');
                }
                $field = new SelectField($this->selectOptionsOptionGroups, $this->selectSelectedValue, $this->label, $this->attributes, $this->errorMessage);
                break;

            case 'textarea':
                $field = new TextareaField($this->textareaValue, $this->label, $this->attributes, $this->errorMessage);
                break;

            default:
                // input
                if ($this->isCheckboxOrRadioInput()) {
                    $field = new CheckboxRadioInputField($this->label, $this->attributes, $this->errorMessage);
                } else {
                    $field = new InputField($this->label, $this->attributes, $this->errorMessage);
                }
        }

        $this->initializeProperties();
        return $field;
    }
}
