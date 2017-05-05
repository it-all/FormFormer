<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

/**
 * Class ImageInputField
 * @package It_All\FormFormer
 * 'The image is given by the src attribute. The src attribute must be present, and must contain a valid non-empty URL potentially surrounded by spaces referencing a non-interactive, optionally animated, image resource that is neither paged nor scripted.'
 * https://www.w3.org/TR/html5/forms.html#image-button-state-(type=image)
 * validate that src is present in generate(), since chaining methods allow adding src attribute after field definition
 */
class ImageInputField extends \It_All\FormFormer\Fields\InputField
{
    protected $type = 'image';

    public function generate(bool $showLabel = false, bool $showReqdOpt = false, bool $showErrorMsg = false, bool $showDescriptor = false, bool $divWrap = true, bool $endWrapperDiv = true): string
    {
        if (!($this->getAttributeByName('src'))) {
            throw new \Exception('The src attribute must be set for image input buttons');
        }
        return parent::generate($showLabel, false, false, $showDescriptor, $divWrap);
    }
}