<?php
declare(strict_types=1);

namespace It_All\FormFormer;

class UserInterfaceHelper
{
    public static function generateElementAttributes(array $attributes): string
    {
        $attributesString = '';
        foreach ($attributes as $aKey => $aValue) {
            $attributeName = strtolower($aKey);
            $attributeValue = htmlentities($aValue, ENT_QUOTES);
            $attributesString .= " $attributeName=\"$attributeValue\"";
        }

        return $attributesString;
    }

    public static function generateElement(string $name, array $attributes, bool $close = true, string $content = '', bool $htmlEntitiesContent = true): string
    {
        if (!$close && mb_strlen($content) > 0) {
            throw new \Exception('Content not allowed in unclosed element');
        }

        $html = '<'.$name.self::generateElementAttributes($attributes).'>';
        if ($close) {
            $html .= $htmlEntitiesContent ? htmlentities($content, ENT_QUOTES) : $content;
            $html .= '</'.$name.'>';
        }
        return $html;
    }
}
