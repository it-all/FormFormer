<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Fieldset extends NodeHolder
{
    public $isFieldset = true; // for twig

    /** nodes are validated in form constructor (these will be validated as long as fieldset is added to form) */
    public function __construct(array $nodes)
    {
        parent::__construct($nodes);
    }
}
