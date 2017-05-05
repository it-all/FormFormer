<?php
declare(strict_types=1);

namespace It_All\FormFormer;

abstract class FieldGroup extends FieldFieldGroup {

    /** @var string the type of field group: radio, checkbox, file (all input fields) */
    protected $type;

    /**
     * @var  the name attribute of each field in the group - required to group the field
     * note for checkbox and file field groups [] is appended to the name to provide grouped functionality
     */
    protected $name;

    /** @var  string similar to field label but <label> doesn't apply to field group */
    private $label;

    /** @var  array of field objects belonging to group */
    protected $fields;

    function __construct(string $name, string $label = '', string $descriptor = '', bool $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->descriptor = $descriptor;
        $this->required = $required;
        $this->fields = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract protected function addFields();

    protected function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    protected function getFieldAttributes()
    {
        return ['name' => $this->name, 'type' => $this->type];
    }

    private function generateHeaderText(): string
    {
        if (strlen($this->label) > 0) {
            return "<span class='ffFieldGroupHeader'>$this->label</span>";
        }
        return "";
    }

    /** can possibly add another form variable such as $divWrapFieldGroups instead of the arg. not sure you'd ever want to not wrap fgs */
    public function generate($divWrap = true): string
    {
        if (count($this->fields) == 0) {
            throw new \Exception('No fields in field group '.$this->getName());
        }
        $html = $this->generateHeaderText();
        $html .= $this->generateReqdOpt();
        $html .= $this->generateErrorMsg();
        $html .= $this->generateDescriptor();
        foreach ($this->fields as $field) {
            $html .= $field->generate();
        }
        if ($divWrap) {
            $html = "<div class='ffGroupWrapper'>$html</div>";
        }
        return $html;
    }
}
