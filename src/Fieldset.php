<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Fieldset extends NodeHolder
{
    public $isFieldset = true; // for twig
    private $legendText;

    /** nodes are validated in form constructor (these will be validated as long as fieldset is added to form) */
    // todo add legend checkbox field as an argument
    // https://www.w3.org/wiki/HTML/Elements/fieldset
    public function __construct(array $nodes, $legendText='')
    {
        parent::__construct($nodes);
        $this->legendText = $legendText;
    }

    public function getLegendText()
    {
        return $this->legendText;
    }
}
