<?php
/**
 * Created by @kondratev.v
 * Date: 16.03.2020 17:42
 */

namespace Telegram\Bot;


class Helper {

    public static function getItemFromArray($items, $key, $default = null) {
        if (array_key_exists($key, $items)) {
            return $items[$key];
        }
        return $default;
    }

    public static function camelToSnake($str) {
        $str[0] = strtolower($str[0]);
        $len = strlen($str);
        for ($i = 0; $i < $len; ++$i) {
            // See if we have an uppercase character and replace; ord A = 65, Z = 90.
            if (ord($str[$i]) > 64 && ord($str[$i]) < 91) {
                // Replace uppercase of with underscore and lowercase.
                $replace = '_' . strtolower($str[$i]);
                $str = substr_replace($str, $replace, $i, 1);
                // Increase length of class and position since we made the string longer.
                ++$len;
                ++$i;
            }
        }
        return $str;
    }
}