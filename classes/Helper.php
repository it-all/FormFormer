<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class Helper
{
    /**
     * @param $attributes
     * @return string
     */
    static public function generateTagAttributes(array $attributes): string
    {
        $html = "";
        $uniqueAttributes = ['novalidate', 'required', 'disabled'];
        foreach ($attributes as $attrName => $attrVal) {
            $attrVal = str_replace("'", "&apos;", $attrVal);
            $html .= (in_array($attrName, $uniqueAttributes)) ? " $attrName" : " $attrName='$attrVal'";
        }
        return $html;
    }
}
