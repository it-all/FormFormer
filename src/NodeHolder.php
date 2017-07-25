<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class NodeHolder
{
    /** @var  array of Field and Fieldset objects, entered in display order
     * Fields within Fieldsets are not nodes
     */
    protected $nodes;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    public function getNodes()
    {
        return $this->nodes;
    }
}
