<?php

namespace App\Commons\Utils;

class StringUtils
{
    public static function nameAndTitle($frontTitle, $name, $backTitle)
    {
        $nameAndTitle = "";
        if ($frontTitle) {
            $nameAndTitle .= $frontTitle . " ";
        }
        $nameAndTitle  .= $name;
        if ($backTitle) {
            $nameAndTitle .= ", " . $backTitle;
        }
        return $nameAndTitle;
    }
}
