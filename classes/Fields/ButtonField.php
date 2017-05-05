<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields;

use It_All\FormFormer\Field;
use It_All\FormFormer\Form;

class ButtonField extends Field
{
    protected $tag = 'button';

    private $content;

    function __construct(array $attributes = [], string $label = '', string $descriptor = '', array $customFieldSettings = [])
    {
        if (isset($customFieldSettings['content'])) {
            $this->content = $customFieldSettings['content'];
        } else {
            $this->content = '';
        }
        parent::__construct($attributes, $label, $descriptor);
    }

    public function content(string $content)
    {
        $this->content = trim($content);
        return $this;
    }

    public function generate(): string
    {
        if (strlen($this->content) == 0) {
            throw new \Exception('No content in button field '.$this->getName());
        }
        return parent::generate(true, false, false, true, true, $this->content);
    }
}
