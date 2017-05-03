<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class ButtonField extends Field
{
    protected $tag = 'button';

    private $content;

    private function setContent(string $content)
    {
        $this->content = $content;
    }

    public function content(string $content)
    {
        $this->setContent(trim($content));
        return $this;
    }

    public function generate(): string
    {
        return parent::generate(true, false, false, true, true, $this->content);
    }
}
