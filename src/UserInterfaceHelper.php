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
            $attributeValue = htmlentities($aValue, ENT_QUOTES | ENT_HTML5);
            $attributesString .= " $attributeName=\"$attributeValue\"";
        }

        return $attributesString;
    }

    public static function generateElement(string $name, array $attributes, bool $close = true, string $content = ''): string
    {
        if (!$close && mb_strlen($content) > 0) {
            throw new \Exception('Content not allowed in unclosed element');
        }

        $html = '<'.$name.self::generateElementAttributes($attributes).'>';
        if ($close) {
            $html .= htmlentities($content, ENT_QUOTES | ENT_HTML5).'</'.$name.'>';
        }
        return $html;
    }
}
